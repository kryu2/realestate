<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CashFlowProgress {

    var $_realestateData = null;       //不動産データ

    /**
      * constructor
     **/
    function CashFlowProgress($params = null) {
        if ($params == null) { return null; }

        $this->_realestateData = new RealestateData($params);
    }

    function setData() {
    }

    /**
      * 表形式でCF試算データを返す
     **/
    function getTable() {
        if ($this->realestateData == null) {
            throw new Exception('realestate data null exception'); 
            return null;
        }

        //初年度の収益データの取得
        $rd = new RowData($this->_realestateData, null);
        for ($i = 1; $i <= 50; $i++) {
            $table[] = $rd->getColumns();
            //2年目以降の収益データの取得
            $rd = new RowData($this->_realestateData, $rd);
        }

        return $table;
    }

    /**
      * 不動産情報を返す
     **/
    function getRealestateData() {
        if ($this->realestateData == null) {
            throw new Exception('realestate data null exception'); 
            return null;
        }

        return $this->realestateData->getData();
    }

    /**
      * setter
     **/
    function __set($name, $value) {
        $field = '_' . $name;
        $this->{$field} = $value;
        if ($name == 'buildDate') {
            $this->_buildingAge = date('Y') - $this->_buildDate;
        }
    }

    /**
      * getter
     **/
    function __get($name) {
        $field = '_' . $name;
        return $this->{$field};
    }
}

/**
 * RealestateData
 * 不動産の情報を保持するクラス
 **/
class RealestateData {
    private $_buildYear      = null;    //建築年(年)
    private $_buildingAge    = null;    //築年数(年)
    private $_purchaseYear   = null;    //購入予定年(年)
    private $_retailPrice    = null;    //販売価格(万)

    private $_fullRentIncome = null;    //満室時家賃収入(万)
    private $_emptyRoomRate  = 15;      //空室率(%)
    private $_realIncome     = null;    //正味家賃収入(万)
    private $_incomeDropRate = 1;       //賃料下落率

    private $_manageCostRate = 5;       //管理費率(%)
    private $_repairCostRate = 15;      //修繕費率(%)

    private $_publicInterestRate = 2;   //国債金利(%)

    private $_loanAmount     = null;    //借入額(万)
    private $_interestRate   = 2.8;     //金利(%)
    private $_loanTerm       = 20;      //借入期間(年)
    private $_selfFund       = 0;       //必要自己資金(万)

    private $_frameType      = 3;       //建築構造
    private $_frameTypeArray = array(   //再調達価格(円), 経済耐用年数(年), 法定耐用年数(年)(居住用), 法定耐用年数(年)(事務所用)
        array(125000, 20, 22, 24),  //木造
        array(120000, 20, 19, 22),  //軽量鉄骨造
        array(170000, 35, 34, 38),  //鉄骨造
        array(190000, 40, 47, 50),  //RC造
        array(210000, 45, 47, 50),  //SRC造
    );
    private $_buildingLifeLeft = null;  //残耐用年数(年)
    private $_totalFloorArea = null;    //延床面積(m2)
    private $_buildingEval   = null;    //建物評価額(万)

    private $_groundArea     = null;    //土地面積(m2)
    private $_roadRating     = null;    //(相続税)路線価(円)
    private $_groundEval     = null;    //土地評価額(万)
    private $_groundValueDropRate = 1;  //土地下落率(%)

    /**
      * constructor
     **/
    function RealestateData($params = null) {
        if ($params == null) {
            return null;
        }

        //パラメータを引数にセット
        foreach ($params as $key => $value) {
            $propertyName = '_' . mb_strtolower($key[0]) . mb_substr($key, 1);
            if (property_exists(get_class($this), $propertyName)) {
                $this->{$propertyName} = $value;
            }
        }

        $this->_processParams();
    }

    /**
      * 設定済みのプロパティから計算が必要なプロパティを処理する
     **/
    function _processParams() {
        //築年数(年)
        $this->_buildingAge = date('Y') - $this->_buildYear;
        if ($this->_buildingAge < 0) {
            $this->_buildingAge = 0;
        }
        //正味家賃収入(万)
        $this->_realIncome = $this->_fullRentIncome * (1 - $this->_emptyRoomRate / 100);
        //残耐用年数(年)
        $this->_buildingLifeLeft =
            $this->_frameTypeArray[$this->_frameType][2] - ($this->_purchaseYear - $this->_buildYear);
        if ($this->_buildingLifeLeft < 0) {
            $this->_buildingLifeLeft = 0;
        }
        //建物評価額(万)
        $this->_buildingEval =
            ($this->_totalFloorArea * $this->_frameTypeArray[$this->_frameType][0] / 10000) *
            (0.9 * $this->_buildingLifeLeft / $this->_frameTypeArray[$this->_frameType][2] + 0.1);
        if ($this->_buildingEval < 0) {
            $this->_buildingEval = 0;
        }
        //土地評価額(万)
        $this->_groundEval = $this->_groundArea * $this->_roadRating / 0.8;
    }

    /**
      * getData
     **/
    function getData() {
        foreach ($this as $key => $value) {
            $propertyName = mb_substr($key, 1);
            $params[$propertyName] = $value;
        }

        return $params;
    }

    /**
      * setter
     **/
    function __set($name, $value) {
        $field = '_' . $name;
        $this->{$field} = $value;
        $this->_processParams();
    }

    /**
      * getter
     **/
    function __get($name) {
        $field = '_' . $name;
        return $this->{$field};
    }
}

/**
 * RowData
 * CFの単年度分のデータを保持するクラス
 **/
class RowData {
    private $_year = null;         //年度(年)

    //■PL
    private $_income = null;       //収入(万)
    //経費
    private $_manageCost = null;  //管理費(万)
    private $_costTax = null;  //固定資産税＋都市計画税(万)
    private $_repairCost = null;  //修繕費用(万)
    private $_depreciationCost = null;  //減価償却費(万)
    //借入内訳
    private $_payAmount = null;  //借入金返済額(万/年)
    private $_payInterest = null;  //利息部分(万)
    private $_payPrincipal = null;  //元金部分(万)
    //税金
    private $_taxTarget = null;  //課税対象(万)
    private $_incomeTax = null;  //税額(万)
    //CF
    private $_returnBeforeTax = null;  //税引き前収益(万)
    private $_returnAfterTax = null;  //税引き後収益(万)

    //■BS
    //現金
    private $_returnBeforeTaxTotal = null;  //税引き前収益積算(万)
    private $_returnAfterTaxTotal = null;  //税引き後利益積算(万)
    //不動産
    private $_buildingValueLeft = null;  //建物残存価値(万)
    private $_groundValue = null;  //土地値(万)
    private $_realestateValue = null;  //土地と建物(万)
    //借入
    private $_debtLeft = null;  //残債(万)

    //■NPV(正味現在価値)
    private $_returnBeforeTaxRebate = null;  //税引き前収益割り戻し(万)
    private $_returnBeforeTaxRebateTotal = null;  //税引き前収益割り戻し積算(万)
    private $_returnAfterTaxRebate = null;  //税引き後収益割り戻し(万)
    private $_returnAfterTaxRebateTotal = null;  //税引き後収益割り戻し積算(万)
    private $_npv = null;  //NPV(万)
    private $_debtLeftRebate = null;  //残債割り戻し(万)

    /**
      * constructor
     **/
    function RowData($realestateData = null, $preRowData = null) {
        //$preRowData が無い場合は初年度、それ以外は次年度以降

        $CI =& get_instance();
        $CI->load->library('Finance_lib');

        //年度(年)
        if ($preRowData == null) {
            $this->_year = $realestateData->purchaseYear;
        } else {
            $this->_year = $preRowData->year + 1;
        }
        //収入(万) = 収入*(1-予想賃料下落率/100)
        if ($preRowData == null) {
            $this->_income = $realestateData->realIncome;
        } else {
            $this->_income = $preRowData->_income * (1 - $realestateData->incomeDropRate / 100);
        }
        //管理費用(万) = 収入*管理費率/100
        $this->_manageCost = $this->_income * $realestateData->manageCostRate / 100;
        //建物残存価値 = IF((年度-購入予定年+1)<残耐用年数,建物評価額-(建物評価額*0.9/残耐用年数)*(年度-購入予定年+1),建物評価額*0.1)
        if (($this->_year - $realestateData->purchaseYear + 1) < $realestateData->buildingLifeLeft) {
            $this->_buildingValueLeft =
                $realestateData->buildingEval - ($realestateData->buildingEval * 0.9 / $realestateData->buildingLifeLeft) * ($this->_year - $realestateData->purchaseYear + 1);
        } else {
            $this->_buildingValueLeft =
                $realestateData->buildingEval * 0.1;
        }
        //土地値(万) = 土地評価額*(1-土地下落率/100)
        if ($preRowData == null) {
            $this->_groundValue = $realestateData->groundEval * (1 - $realestateData->groundValueDropRate / 100);
        } else {
            $this->_groundValue = $preRowData->groundValue * (1 - $realestateData->groundValueDropRate / 100);
        }
        //土地と建物(万) = 建物残存価値+土地値
        $this->_realestateValue = $this->_buildingValueLeft + $this->_groundValue;
        //固定資産税と都市計画税(万) = ((土地値*0.8)/6*0.8+(建物残存価値*0.8))*0.014+((土地値*0.8)/3+(建物残存価値*0.8))*0.003
        $this->_costTax =
            (($this->_groundValue * 0.8) / 6 * 0.8 + ($this->_buildingValueLeft * 0.8)) * 0.014 +
            (($this->_groundValue * 0.8) / 3 + ($this->_buildingValueLeft * 0.8)) * 0.003;
        //修繕費用(万) = 収入*修繕費率/100
        $this->_repairCost = $this->_income  * $realestateData->repairCostRate / 100;
        //減価償却費 = IF(年度-購入予定年<税法上の耐用年数(法定耐用年数,購入予定年-建築年),販売価格*建物評価額/(建物評価額+土地評価額)*0.9/税法上の耐用年数(法定耐用年数,購入予定年-建築年),0)
        if ($this->_year - $realestateData->purchaseYear < $this->_getLifeOnTaxLaw($realestateData->frameTypeArray[$realestateData->frameType][2], $realestateData->purchaseYear - $realestateData->buildYear)) {
            try {
                if (!($realestateData->buildingEval + $realestateData->groundEval)) {
                    throw new Exception('Division by zero');
                }
                $this->_depreciationCost =
                $realestateData->retailPrice * $realestateData->buildingEval / ($realestateData->buildingEval + $realestateData->groundEval) * 0.9 / $this->_getLifeOnTaxLaw($realestateData->frameTypeArray[$realestateData->frameType][2], $realestateData->purchaseYear - $realestateData->buildYear);

                if ($this->_depreciationCost < 0) {
                    $this->_depreciationCost = 0;
                }
            } catch(Exception $e) {
                $this->_depreciationCost = 0;
            }
        } else {
            $this->_depreciationCost = 0;
        }
        //借入金返済額(万) = IF(年度-購入予定年<期間,-PMT(金利/100/12,期間*12,借入額)*12,0)
        if ($this->_year - $realestateData->purchaseYear < $realestateData->loanTerm) {
            try {
                //1月分の返済額を
                $payAmountPerMonth = $CI->finance_lib->pmt($realestateData->interestRate / 100 / 12, $realestateData->loanTerm * 12, $realestateData->loanAmount);
                //12倍して1年分にする
                $this->_payAmount = $payAmountPerMonth * 12;
            } catch(Exception $e) {
                $this->_payAmount = 0;
            }
        } else {
            $this->_payAmount = 0;
        }
        //利息部分(万)
        if ($this->_payAmount) {
            $this->_payInterest = $this->_getPayInterest($this->_year - $realestateData->purchaseYear + 1, $realestateData->interestRate, $realestateData->loanTerm, $realestateData->loanAmount, $payAmountPerMonth);
        } else {
            $this->_payInterest = 0;
        }
        //元金部分(万)
        if ($this->_payAmount) {
            $this->_payPrincipal = $this->_payAmount - $this->_payInterest;
        } else {
            $this->_payPrincipal = 0;
        }
        //課税対象(万) = 収入-(管理費用+固定資産税と都市計画税+修繕費用)-利息部分-減価償却費
        if ($preRowData == null) {
            //TODO:(販売価格*0.04) 暫定的に4%で初期費用を計上
            $this->_taxTarget =
                $this->_income - ($this->_manageCost + $this->_costTax + $this->_repairCost) - $this->_payInterest - $this->_depreciationCost - ($realestateData->retailPrice * 0.04);
        } else {
            $this->_taxTarget =
                $this->_income - ($this->_manageCost + $this->_costTax + $this->_repairCost) - $this->_payInterest - $this->_depreciationCost;
        }
        //税額(万) = IF(課税対象<=0,0,課税対象*0.3)
        if (0 < $this->_taxTarget) {
            $this->_incomeTax = $this->_taxTarget * 0.3;
        } else {
            $this->_incomeTax = 0;
        }
        //税引き前収益(万) = 収入-(管理費用+固定資産税と都市計画税+修繕費用)-借入金返済額
        $this->_returnBeforeTax = $this->_income - ($this->_manageCost + $this->_costTax + $this->_repairCost) - $this->_payAmount;
        //税引き後収益(万) = 税引き前収益-税額
        $this->_returnAfterTax = $this->_returnBeforeTax - $this->_incomeTax;
        //税引き前収益積算(万) = 税引き前収益 の積算
        if ($preRowData == null) {
            $this->_returnBeforeTaxTotal = $this->_returnBeforeTax;
        } else {
            $this->_returnBeforeTaxTotal = $preRowData->returnBeforeTaxTotal + $this->_returnBeforeTax;
        }
        //税引き後利益積算(万) = 税引き後収益 の積算
        if ($preRowData == null) {
            $this->_returnAfterTaxTotal = $this->_returnAfterTax;
        } else {
            $this->_returnAfterTaxTotal = $preRowData->returnAfterTaxTotal + $this->_returnAfterTax;
        }
        //建物残存価値 = IF((年度-購入予定年+1)<残耐用年数,建物評価額-(建物評価額*0.9/残耐用年数)*(年度-購入予定年+1),建物評価額*0.1)
        if ($this->_year - $realestateData->purchaseYear + 1 < $realestateData->buildingLifeLeft) {
            $this->_buildingValueLeft =
                $realestateData->buildingEval - ($realestateData->buildingEval * 0.9 / $realestateData->buildingLifeLeft) * ($this->_year - $realestateData->purchaseYear + 1);
        } else {
            $this->_buildingValueLeft =
                $realestateData->buildingEval * 0.1;
        }
        if ($this->_buildingValueLeft < 0) {
            $this->_buildingValueLeft = 0;
        }
        //残債(万) = 残債-元金部分
        if ($preRowData == null) {
            $this->_debtLeft = $realestateData->loanAmount - $this->_payPrincipal;
        } else {
            $this->_debtLeft = $preRowData->debtLeft - $this->_payPrincipal;
            if ($this->_debtLeft < 1) {
                $this->_debtLeft = 0;
            }
        }
        //税引き前収益割り戻し(万) = 税引き前収益/POWER(1+国債金利/100,年度-購入予定年+1)
        $this->_returnBeforeTaxRebate =
            $this->_returnBeforeTax / pow(1 + $realestateData->publicInterestRate / 100, $this->_year - $realestateData->purchaseYear + 1);
        //税引き前収益割り戻し積算(万) = 税引き前収益割り戻し の積算
        if ($preRowData == null) {
            $this->_returnBeforeTaxRebateTotal = $this->_returnBeforeTaxRebate;
        } else {
            $this->_returnBeforeTaxRebateTotal = $preRowData->returnBeforeTaxRebateTotal + $this->_returnBeforeTaxRebate;
        }
        //税引き後収益割り戻し(万) = 税引き後収益/POWER(1+国債金利/100,年度-購入予定年+1)
        $this->_returnAfterTaxRebate = 
            $this->_returnAfterTax / pow(1 + $realestateData->publicInterestRate / 100, $this->_year - $realestateData->purchaseYear + 1);
        //税引き後収益割り戻し積算(万) = 税引き後収益割り戻し の積算
        if ($preRowData == null) {
            $this->_returnAfterTaxRebateTotal = $this->_returnAfterTaxRebate;
        } else {
            $this->_returnAfterTaxRebateTotal = $preRowData->returnAfterTaxRebateTotal + $this->_returnAfterTaxRebate;
        }
        //NPV(万) = 税引き後収益割り戻し積算+土地と建物-(残債/POWER(1+国債金利/100,年度-購入予定年+1))-必要自己資金
        $this->_npv = $this->_returnAfterTaxRebateTotal + $this->_realestateValue - ($this->_debtLeft / pow(1 + $realestateData->publicInterestRate / 100, $this->_year - $realestateData->purchaseYear + 1)) - $realestateData->selfFund;
        //残債割り戻し(万) = 残債/POWER((1+国債金利/100),年度-購入予定年+1)
        $this->_debtLeftRebate = $this->_debtLeft / pow(1 + $realestateData->publicInterestRate / 100, $this->_year - $realestateData->purchaseYear + 1);




        if ($preRowData == null) {
        } else {
        }
    }

    /**
      * 1年度分のデータを返す
     **/
    function getColumns() {
        foreach ($this as $key => $value) {
            $results[mb_substr($key, 1)] = $value;
        }

        return $results;
    }

    /**
      * 税法上の耐用年数(法定耐用年数, 経過年数)を返す
     **/
    function _getLifeOnTaxLaw($lifeOnLegal = null, $passedYears = null) {
        if (0 <= $lifeOnLegal - $passedYears) {
            //法定年数の一部を経過したもの
            return $lifeOnLegal - $passedYears + ($passedYears * 0.2);
        } else {
            //法定耐用年数の全部を経過したもの
            return $lifeOnLegal * 0.2;
        }
    }
    /**
      * 利息部分(年)算出(対象期, 金利, 期間, 借入額, 借入金返済額(月))(万)を返す
     **/
    function _getPayInterest($per = null, $interestRate = null, $loanTerm = null, $loanAmount = null, $payAmountPerMonth = null) {
        if ($loanTerm < $per) {
            return 0;
        }
        $payInterestTotal = 0;
        $amountLeft = $loanAmount * 10000;
        $payAmountPerMonth = $payAmountPerMonth * 10000;
        //年数*12ヶ月分ループ
        for ($i = 1; $i <= $loanTerm * 12; $i++) {
            $payInterest = $amountLeft * ($interestRate / 100 / 12);
            $amountLeft = $amountLeft - ($payAmountPerMonth - $payInterest);
            //対象期を超えたら終了
            if ($per * 12 + 1 <= $i) {
                break;
            }
            //対象期は12ヶ月分を積算
            if (($per -1) * 12 + 1 <= $i) {
                $payInterestTotal = $payInterestTotal + $payInterest;
            }
        }

        return $payInterestTotal / 10000;
    }

    /**
      * getter
     **/
    function __get($name) {
        $field = '_' . $name;
        return $this->{$field};
    }
}

?>