<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\FinanceLibrary;


class IntegrationModel extends Model {
    var $_roadRating = null;      //(相続税)路線価(円)
    var $_groundArea = null;      //土地面積(m2)

    var $_totalFloorArea = null;  //延床面積(m2)
    var $_frameType = 3;          //建築構造
    var $_frameTypeArray = array( //再調達価格(円), 経済耐用年数(年), 法定耐用年数(年)(居住用), 法定耐用年数(年)(事務所用)
        array(125000, 20, 22, 24),     //木造
        array(120000, 20, 19, 22),     //軽量鉄骨造
        array(170000, 35, 34, 38),     //鉄骨造
        array(200000, 40, 47, 50),     //RC造
        array(210000, 45, 47, 50),     //SRC造
    );
    var $_buildDate = null;            //建築年(年)
    var $_buildingAge = null;          //築年数(年)

    var $_groundSecurityRate = 0.7;    //土地担保比率
    var $_buildingSecurityRate = 0.6;  //建物担保比率

    var $_currentPrice = null;         //積算評価額

    var $_retailPrice = null;          //販売価格
    var $_fullRentIncome = null;       //満室時家賃収入
    var $_realIncome = null;           //正味家賃収入
    var $_faceYield = null;            //表面利回り
    var $_realYield = null;            //実質利回り

    var $_capacityRatio = null;        //容積率
    var $_isCapacityOver = null;       //容積率オーバーかどうか
    var $_roadBorderCount = null;      //道路付け
    var $_residenceCount = null;       //戸数

    var $_emptyRoomRate = 15;          //空室率

    var $_loanTerm = 20;               //借入期間(年)
    var $_interestRate = 2.8;          //金利(%)
    var $_loanAmount = null;           //借入額

    var $_buildingPropertyTax = null;  //固定資産税(建物)
    var $_groundPropertyTax = null;    //固定資産税(土地)
    var $_damageInsurance = null;      //損害保険料
    var $_cost = null;                 //経費
    var $_noi = null;                  //正味不動産収益(NOI)
    var $_loanPayment = null;          //ローン支払額
    var $_dscr = null;                 //返済余裕率(DSCR)

    var $_cf = null;                   //キャッシュフロー
    var $_billionCf = null;            //1億換算時のキャッシュフロー

    //constructor
    public function __construct($roadRating = 0, $groundArea = 0, $totalFloorArea = 0, $frameType = 0, $buildDate = 0, $groundSecurityRate = 0.7, $buildingSecurityRate = 0.6) {
        $this->_roadRating = $roadRating;
        $this->_groundArea = $groundArea;

        $this->_totalFloorArea = $totalFloorArea;
        $this->_frameType = $frameType;
        $this->_buildDate = $buildDate;
        $this->_buildingAge = date('Y') - $this->_buildDate;

        $this->_groundSecurityRate = $groundSecurityRate;
        $this->_buildingSecurityRate = $buildingSecurityRate;
    }

    /*
     * パラメータのセット
     */
    public function setParams($params) {
        // $CI =& get_instance();
        // $CI->load->library('Finance_lib');
        // helper(['FinanceLibrary']);
        $fl = new FinanceLibrary();

        //販売価格
        $this->_retailPrice = $params['retailPrice'];
        //満室時家賃収入
        $this->_fullRentIncome = $params['fullRentIncome'];
        //建築年
        $this->_buildDate = $params['buildDate'];
        //築年数
        $this->_buildingAge = date('Y') - $this->_buildDate;
        //躯体構造
        $this->_frameType = $params['frameType'];


        //路線価
        $this->_roadRating = $params['roadRating'];
        //土地面積
        $this->_groundArea = $params['groundArea'];
        //延床面積
        $this->_totalFloorArea = $params['totalFloorArea'];

        //容積率
        $this->_capacityRatio = $params['capacityRatio'];
        try {
            if (!$this->_groundArea) {
                throw new Exception('Division by zero');
            }
            $this->_isCapacityOver = ($this->_capacityRatio <= ($this->_totalFloorArea / $this->_groundArea * 100));
        } catch (Exception $e) {
            $this->_isCapacityOver = null;
        }
        //道路付け
        $this->_roadBorderCount = $params['roadBorderCount'];
        //戸数
        $this->_residenceCount = $params['residenceCount'];

        //■担保比率
        //土地担保比率
        if (isset($params['groundSecurityRate'])) {
            $this->_groundSecurityRate = $params['groundSecurityRate'];
        }
        //建物担保比率
        if (isset($params['buildingSecurityRate'])) {
            $this->_buildingSecurityRate = $params['buildingSecurityRate'];
        }

        //積算評価額
        $this->_currentPrice = ($this->getCurrentPrice()) ? $this->getCurrentPrice() : 0;
        //想定空室率
        if (is_numeric($params['emptyRoomRate'])) {
            $this->_emptyRoomRate = $params['emptyRoomRate'];
        }
        //正味家賃収入
        try {
            if (!($this->_fullRentIncome * (100 - $this->_emptyRoomRate))) {
                throw new Exception('Division by zero');
            }
            $this->_realIncome = $this->_fullRentIncome * (100 - $this->_emptyRoomRate) / 100;
        } catch (Exception $e) {
            $this->_realIncome = null;
        }
        //固定資産税(建物)
        //  償却率
        try {
            if (!$this->_frameType and (count($this->_frameType) - $this->_frameType) < 1) {
                throw new Exception('躯体構造の指定に問題があります');
            }
            $depreciationRatio = ($this->_frameTypeArray[$this->_frameType][2] - $this->_buildingAge) / $this->_frameTypeArray[$this->_frameType][2] * 0.8;
            if ($depreciationRatio < 0) {
                $depreciationRatio = 0;
            }
        } catch (Exception $e) {
            $depreciationRatio = null;
        }
        //  $s .= '<tr><td>・償却率</td><td>' . $depreciationRatio . '円</td></tr>';
        //  経年減点補正率(定額法2割計算)
        $reviseRatio = ($depreciationRatio + 0.2) * 1.1;
        //  $s .= '<tr><td>・経年減点補正率</td><td>' . $reviseRatio . '円</td></tr>';
        try {
            if (!$this->_totalFloorArea) {
                throw new Exception('延床面積の指定に問題があります');
            }
            if (!$this->_frameType and (count($this->_frameType) - $this->_frameType) < 1) {
                throw new Exception('躯体構造の指定に問題があります');
            }
            if (!$reviseRatio) {
                throw new Exception('償却率の評価に問題があるようです');
            }
            $this->_buildingPropertyTax = $this->_totalFloorArea * $this->_frameTypeArray[$this->_frameType][0] * 0.65 * $reviseRatio * 1.7 / 100;
        } catch (Exception $e) {
            $this->_buildingPropertyTax = null;
        }
        //固定資産税(土地)
        try {
            if (!$this->_roadRating) {
                throw new Exception('路線価の指定に問題があります');
            }
            if (!$this->_groundArea) {
                throw new Exception('土地面積の指定に問題があります');
            }
            $this->_groundPropertyTax = ($this->_roadRating / 8 * 7) * $this->_groundArea / 6 * 1.7 /100;
        } catch (Exception $e) {
            $this->_groundPropertyTax = null;
        }
        //損害保険料
        try {
            if (!$this->_totalFloorArea) {
                throw new Exception('延床面積の指定に問題があります');
            }
            if (!$this->_frameType and (count($this->_frameType) - $this->_frameType) < 1) {
                throw new Exception('躯体構造の指定に問題があります');
            }
            $this->_damageInsurance = $this->_totalFloorArea * $this->_frameTypeArray[$this->_frameType][0] * 0.25 / 100;
        } catch (Exception $e) {
            $this->_damageInsurance = null;
        }
        //経費
        try {
            if (!$this->_realIncome) {
                throw new Exception('正味家賃収入の評価に問題があるようです');
            }
            if (!$this->_fullRentIncome) {
                throw new Exception('満室自家賃収入の評価に問題があるようです');
            }
            if ($this->_buildingPropertyTax and $this->_groundPropertyTax) {
                $this->_cost =
                    $this->_realIncome * 6 /100 +
                    $this->_fullRentIncome * 5 /100 +
                    $this->_buildingPropertyTax +
                    $this->_groundPropertyTax +
                    $this->_damageInsurance;
            } else {
                $this->_cost = $this->_fullRentIncome * 0.15;
            }
        } catch (Exception $e) {
            $this->_cost = null;
        }
        //正味不動産収益(NOI)
        $this->_noi = $this->_realIncome - $this->_cost;
        //表面利回り
        try {
            if (!$this->_retailPrice) {
                throw new Exception('Division by zero');
            }
            $this->_realYield = ($this->_realIncome - $this->_cost) / $this->_retailPrice * 100;
        } catch (Exception $e) {
            $this->_realYield = null;
        }

        //■ローン情報
        //借入期間(年)
        if (is_numeric($params['loanTerm'])) {
            //ユーザーの指定があれば設定
            $this->_loanTerm = $params['loanTerm'];
        } else {
            //無ければ「法定耐用年数-築年数」
            $this->_loanTerm = $this->_frameTypeArray[$this->_frameType][2] - $this->_buildingAge;
            if ($this->_loanTerm < 0) {
                $this->_loanTerm = 0;
            }
            if (30 < $this->_loanTerm) {
                $this->_loanTerm = 30;
            }
        }
        //金利(%)
        if (is_numeric($params['interestRate'])) {
            $this->_interestRate = $params['interestRate'];
        }
        //借入額
        if (is_numeric($params['loanAmount'])) {
            $this->_loanAmount = $params['loanAmount'];
        }
        //ローン支払額(月)
        try {
            $this->_loanPayment = $fl->pmt($this->_interestRate /100 /12, $this->_loanTerm * 12, $this->_loanAmount);
        } catch (Exception $e) {
            $this->_loanPayment = null;
        }

        //返済余裕率(DSCR)
        try {
            if (!$this->_loanPayment) {
                throw new Exception('Division by zero');
            }
            $this->_dscr = $this->_noi / ($this->_loanPayment * 12);
        } catch (Exception $e) {
            $this->_dscr = null;
        }

        //■キャッシュフロー
        //キャッシュフロー(月)
        try {
            if (!$this->_loanPayment) {
                throw new Exception('Division by zero');
            }
            $this->_cf = $this->_noi - ($this->_loanPayment * 12);
        } catch (Exception $e) {
            $this->_cf = null;
        }
        //1億当たりのキャッシュフロー
        try {
            if (!$this->_loanAmount) {
                throw new Exception('Division by zero');
            }
            $this->_billionCf = $this->_cf * (100000000 / $this->_loanAmount);
        } catch (Exception $e) {
            $this->_billionCf = null;
        }

    }

    /*
     * 結果の取得
     */
    public function getResults($params) {
        $this->setParams($params);

        $results = array(
            'totalFloorArea'   => $this->_totalFloorArea,
            'buildDate'   => $this->_buildDate,
            'buildingAge' => $this->_buildingAge,
            'groundSecurityRate'   => $this->_groundSecurityRate,
            'buildingSecurityRate' => $this->_buildingSecurityRate,
            'frameType'         => $this->_frameType,
            'repurchaseCost'    => $this->_frameTypeArray[$this->_frameType][0],
            'economyLifePeriod' => $this->_frameTypeArray[$this->_frameType][1],
            'legalLifePeriodResidence' => $this->_frameTypeArray[$this->_frameType][2],
            'legalLifePeriodOffice'    => $this->_frameTypeArray[$this->_frameType][3],
            'roadRating'      => $this->_roadRating,
            'groundArea'      => $this->_groundArea,
            'groundPrice'     => $this->getGroundPrice(),
            'buildingPrice'   => $this->getBuildingPrice(),
            'currentPrice'    => $this->_currentPrice,
            'securityPrice'   => $this->getSecurityPrice(),
            'retailPrice'     => $this->_retailPrice,
            'fullRentIncome'  => $this->_fullRentIncome,
            'emptyRoomRate'   => $this->_emptyRoomRate,
            'realIncome'      => $this->_realIncome,
            'faceYield'       => $this->getFaceYield(),
            'ltv'             => $this->getLtv(),
            'loanAmount'      => $this->_loanAmount,
            'loanTerm'        => $this->_loanTerm,
            'interestRate'    => $this->_interestRate,
            'capacityRatio'   => $this->_capacityRatio,
            'isCapacityOver'  => $this->_isCapacityOver,
            'roadBorderCount' => $this->_roadBorderCount,
            'residenceCount' => $this->_residenceCount,

            'buildingPropertyTax' => $this->_buildingPropertyTax,
            'groundPropertyTax'   => $this->_groundPropertyTax,
            'damageInsurance'     => $this->_damageInsurance,
            'cost'        => $this->_cost,
            'noi'         => $this->_noi,
            'realYield'   => $this->_realYield,
            'loanPayment' => $this->_loanPayment,
            'dscr'        => $this->_dscr,
            'cf'          => $this->_cf,
            'billionCf'   => $this->_billionCf,

            //'evaluationValues' => $this->getEvaluationValues(),
        );

        return $results;
    }

    //土地価格の取得
    public function getGroundPrice() {
        if ($this->_roadRating == null) { return null; }
        if ($this->_groundArea == null) { return null; }

        return $this->_roadRating * $this->_groundArea;
    }

    //建物価格の取得
    public function getBuildingPrice() {
        try {
            if (!$this->_frameType and (count($this->_frameType) - $this->_frameType) < 1) {
                throw new Exception('躯体構造の指定に問題があります');
            }
            $price = $this->_frameTypeArray[$this->_frameType][0] * $this->_totalFloorArea * ($this->_frameTypeArray[$this->_frameType][2] - $this->_buildingAge) / $this->_frameTypeArray[$this->_frameType][2];
            $price = (0 <= $price) ? $price : 0;
        } catch (Exception $e) {
            $price = null;
        }
        return $price;
    }

    //時価評価額の取得
    public function getCurrentPrice() {
        return
            (($this->getGroundPrice() == null) ? 0 : $this->getGroundPrice()) + 
            (($this->getBuildingPrice() == null) ? 0 : $this->getBuildingPrice());
    }

    //担保評価額の取得
    public function getSecurityPrice() {
        if ($this->getGroundPrice() == null) {
            return null;
        }
        if ($this->getBuildingPrice() == null) {
            return $this->getGroundPrice() * $this->_groundSecurityRate;
        }
        return $this->getGroundPrice() * $this->_groundSecurityRate + $this->getBuildingPrice() * $this->_buildingSecurityRate;
    }

    //表面利回りの取得
    public function getFaceYield() {
        try {
            if (!$this->_retailPrice) {
                throw new Exception('Division by zero');
            }
            $faceYield = $this->_fullRentIncome / $this->_retailPrice * 100;
        } catch (Exception $e) {
            $faceYield = null;
        }
        return $faceYield;
        //if ($this->_fullRentIncome <> 0 and $this->_retailPrice <> 0) {
        //    return $this->_fullRentIncome / $this->_retailPrice * 100;
        //} else {
        //    return 0;
        //}
    }

    //借入金比率(LTV)の取得
    public function getLtv() {
        try {
            if (!$this->_retailPrice) {
                throw new Exception('Division by zero');
            }
            $ltv = $this->_loanAmount / $this->_retailPrice * 100;
        } catch (Exception $e) {
            $ltv = null;
        }
        return $ltv;
    }

        //評価情報の取得
    public function getEvaluationValues() {
        $s = '<table>';

        $s .= '<tr><td>購入価格</td><td>' . number_format(round($this->_retailPrice, -3)) . '円</td></tr>';
        $s .= '<tr><td>担保評価額</td><td>' . number_format(round($this->getSecurityPrice(), -3)) . '円</td></tr>';
        $s .= '<tr><td>満室時家賃収入</td><td>' . number_format(round($this->_fullRentIncome, -3)) . '円</td></tr>';
        $s .= '<tr><td>正味家賃収入</td><td>' . number_format(round($this->_realIncome, -3)) . '円</td></tr>';

        $s .= '<tr><td>・管理費</td><td>' . number_format(round($this->_realIncome * 6 /100, -3)) . '円</td></tr>';
        $s .= '<tr><td>・修繕費</td><td>' . number_format(round($this->_fullRentIncome * 5 /100, -3)) . '円</td></tr>';
        $s .= '<tr><td>・固定資産税(建物)</td><td>' . number_format(round($this->_buildingPropertyTax, -3)) . '円</td></tr>';
        $s .= '<tr><td>・固定資産税(土地)</td><td>' . number_format(round($this->_groundPropertyTax, -3)) . '円</td></tr>';
        $s .= '<tr><td>・損害保険料</td><td>' . number_format(round($this->_damageInsurance, -3)) . '円</td></tr>';

        $s .= '<tr><td>経費</td><td>' . number_format(round($this->_cost, -3)) . '円</td></tr>';

        $s .= '<tr><td>正味不動産収益(NOI)</td><td>' . number_format(round($this->_noi)) . '円</td></tr>';
        $s .= '<tr><td>実質利回り</td><td>' . number_format($this->_realYield, 1) . '%</td></tr>';

        $s .= '<tr><td>借入期間</td><td>' . number_format($this->_loanTerm) . '年</td></tr>';
        $s .= '<tr><td>金利</td><td>' . number_format($this->_interestRate, 1) . '%</td></tr>';

        $s .= '<tr><td>ローン支払額(年)</td><td>' . number_format(round($this->_loanPayment * 12, -3)) . '円</td></tr>';

        $s .= '<tr><td>返済余裕率(DSCR)</td><td>' . number_format($this->_dscr, 2) . '</td></tr>';

        $s .= '<tr><td>キャッシュフロー(年)</td><td>' . number_format(round($this->_cf, -3)) . '円</td></tr>';

        $s .= '<tr><td>1億当たりのキャッシュフロー</td><td>' . number_format(round($this->_billionCf, -3)) . '円</td></tr>';

        $s .= '</table>';

        return $s;
    }

    //1億当たりのキャッシュフロー
    public function getReductionCF($iCF = null) {
        $cf = ($iCF <> null) ? $iCF : $this->_cf;
        return $cf * 100000000 / $this->_cf;
    }

    //setter
    public function __set($name, $value) {
        $field = '_' . $name;
        $this->{$field} = $value;
        if ($name == 'buildDate') {
            $this->_buildingAge = date('Y') - $this->_buildDate;
        }
    }

    //getter
    public function __get($name) {
        $field = '_' . $name;
        return $this->{$field};
    }
}
?>
