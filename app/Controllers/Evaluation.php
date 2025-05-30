<?php
namespace App\Controllers;
use App\Models\IntegrationModel;

class Evaluation extends BaseController {
	public function __construct()
	{
		// parent::__construct();
		date_default_timezone_set('Asia/Tokyo');
		helper(['form', 'realestate_helper']);
	}

	/**
	 *
	**/
	public function index()
	{
		$temp = array();
		$data = array();
		// $data['header_data'] = $this->load->view('realestate/header_data', $temp, True);
		// $data['footer_data'] = $this->load->view('realestate/footer_data', $temp, True);
        // return '現在構築中です。動作の保証ができません。 2022/7/14';
		return view('realestate/evaluation', $data);
	}

	/**
	 *
	**/
	public function getEvaluationValues()
	{
		$integrationModel = new IntegrationModel();
		$params = array(
		    'roadRating' => $this->request->getVar('RoadRating') * 10000,
		    'groundArea' => $this->request->getVar('GroundArea'),

		    'totalFloorArea' => $this->request->getVar('TotalFloorArea'),
		    'frameType'      => $this->request->getVar('FrameType'),
		    'buildDate'      => $this->request->getVar('BuildDate'),

		    'retailPrice'    => $this->request->getVar('RetailPrice') * 10000,
		    'fullRentIncome' => $this->request->getVar('FullRentIncome') * 10000,
		    'emptyRoomRate'  => $this->request->getVar('EmptyRoomRate'),

		    'capacityRatio'  => $this->request->getVar('CapacityRatio'),
		    'roadBorderCount' => $this->request->getVar('RoadBorderCount'),
		    'residenceCount' => $this->request->getVar('ResidenceCount'),

		    'loanTerm' => $this->request->getVar('LoanTerm'),
		    'interestRate' => $this->request->getVar('InterestRate'),
		    'loanAmount' => $this->request->getVar('LoanAmount') * 10000,

		);
		$this->res = $integrationModel->getResults($params);

		//フルローンの場合
		$params['loanAmount'] = $this->request->getVar('RetailPrice') * 10000;
		$data['full'] = $integrationModel->getResults($params);
		//90%の場合
		$params['loanAmount'] = $this->request->getVar('RetailPrice') * 0.90 * 10000;
		$data['x90'] = $integrationModel->getResults($params);
		//積算評価額の場合
		$params['loanAmount'] = $data['full']['currentPrice'];
		$data['quantity'] = $integrationModel->getResults($params);
		//担保評価額の場合
		$params['loanAmount'] = $data['full']['securityPrice'];
		$data['security'] = $integrationModel->getResults($params);
		//設定額の場合
		$params['loanAmount'] = $this->request->getVar('LoanAmount') * 10000;
		$data['setting'] = $integrationModel->getResults($params);

		//物件を直接指定する場合のURLの作成
		$params = array();
		// foreach ($this->getRealEstateParams() as $param => $value) {
		//     if ($this->request->getVar($param) <> '') {
		//         $params[] = $param . '/' . $this->request->getVar($param);
		//         $ses_params[$param] = $this->request->getVar($param);
		//     }
		// }
		$evalUrl = base_url() . 'index.php/evaluation/index/' . implode('/',  $params);

		$data['evalUrl'] = $evalUrl;

		//築年数データの更新
		// $this->xr->assign('BuildingAge', 'innerHTML', $this->res['buildingAge']);

		return view('realestate/evaluation_report', $data);
	}

	/**
	 * スペース削除フィルタ(add mkoba)
	**/
	private function stripspaces($string){
		$all="　";//全角スペース
		$half=" ";//半角スペース
		$tab="\t";//タブ
		$string=str_replace(array($all,$half,$tab),"",$string);
		return $string;
	}
}
?>