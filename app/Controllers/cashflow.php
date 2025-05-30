<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashflow extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Tokyo'); 

		$this->load->library('RA_Session');
		$this->load->library('UseOpenFlashChart');
	}

    public function index()
    {
        $this->load->helper('realestate_helper');

        $params = array(
            'BuildYear'      => $this->input->post('BuildYear'),
            'PurchaseYear'   => $this->input->post('PurchaseYear'),
            'RetailPrice'    => $this->input->post('RetailPrice'),

            'FullRentIncome' => $this->input->post('FullRentIncome'),
            'EmptyRoomRate'  => $this->input->post('EmptyRoomRate'),
            //'IncomeDropRate' => $this->input->post('IncomeDropRate'),

            //'ManageCostRate' => $this->input->post('ManageCostRate'),
            //'RepairCostRate' => $this->input->post('RepairCostRate'),

            //'PublicInterestRate' => $this->input->post('PublicInterestRate'),

            'LoanAmount'     => $this->input->post('LoanAmount'),
            'InterestRate'   => $this->input->post('InterestRate'),
            'LoanTerm'       => $this->input->post('LoanTerm'),
            //'SelfFund'       => $this->input->post('SelfFund'),

            'FrameType'      => $this->input->post('FrameType'),
            'TotalFloorArea' => $this->input->post('TotalFloorArea'),

            'GroundArea'     => $this->input->post('GroundArea'),
            'RoadRating'     => $this->input->post('RoadRating'),
            //'GroundValueDropRate' => $this->input->post('GroundValueDropRate'),
        );
        $this->load->library('CashFlowProgress', $params);

        $temp = array();
        $data['footer_data'] = $this->load->view('realestate/footer_data', $temp, True);
        $rd = $this->cashflowprogress->getRealestateData();
        $data['rd'] = $rd;
        $cfp = $this->cashflowprogress->getTable();
        $data['cfp'] = $cfp;

        $v = $this->load->view('realestate/cashflow_progress', $data, True);

        $cf_graph_data = array();
        //グラフの左側に隙間を空けるためのnullデータ
        for ($i = 2005; $i < $rd['purchaseYear']; $i++) {
            $temp = array(
                'realestateValue'      => null,
                'returnAfterTax'       => null,
                'returnBeforeTaxTotal' => null,
                'returnAfterTaxTotal'  => null,
                'debtLeft'             => null,
                'npv'                  => null,
            );
            $cf_graph_data[] = $temp;
        }
        //グラフのデータ
        foreach ($cfp as $row) {
            $temp = array(
                'realestateValue'      => (int)$row['realestateValue'],
                'returnBeforeTaxTotal' => (int)$row['returnBeforeTaxTotal'],
                'returnAfterTaxTotal'  => (int)$row['returnAfterTaxTotal'],
                'debtLeft'             => (int)$row['debtLeft'],
                'npv'                  => (int)$row['npv'],
            );
            $cf_graph_data[] = $temp;
        }

        $this->ra_session->unset_userdata('cf_graph_data');
        $this->ra_session->set_userdata('cf_graph_data', serialize($cf_graph_data));

        echo $v;
    }

    /**
      * CFグラフ用データの生成
     **/
    public function cf_data()
    {
        $npv = array();

        $cf_graph_data = unserialize($this->ra_session->userdata('cf_graph_data'));

        foreach ($cf_graph_data as $row) {
            $realestateValue[]      = $row['realestateValue'];
            $returnBeforeTaxTotal[] = $row['returnBeforeTaxTotal'];
            $returnAfterTaxTotal[]  = $row['returnAfterTaxTotal'];
            $debtLeft[]             = $row['debtLeft'];
            $npv[]                  = $row['npv'];
        }

        $title = new title( "キャッシュフローの遷移" );

        //不動産価値
        $realestateValue_line = new line();
        $realestateValue_line->set_values($realestateValue);
        $realestateValue_line->set_width(2);
        $realestateValue_line->set_colour('#993300');

        //税引き前収益積算
        $returnBeforeTaxTotal_line = new line();
        $returnBeforeTaxTotal_line->set_values($returnBeforeTaxTotal);
        $returnBeforeTaxTotal_line->line_style( new line_style(4, 3) );
        $returnBeforeTaxTotal_line->set_width(2);
        $returnBeforeTaxTotal_line->set_colour('#0000ff');

        //税引き後収益積算
        $returnAfterTaxTotal_line = new line();
        $returnAfterTaxTotal_line->set_values($returnAfterTaxTotal);
        $returnAfterTaxTotal_line->set_width(2);
        $returnAfterTaxTotal_line->set_colour('#0000ff');

        //残債
        $debtLeft_line = new line();
        $debtLeft_line->set_values($debtLeft);
        $debtLeft_line->set_width(2);
        $debtLeft_line->set_colour('#ff0099');

        //NPV
        $npv_line = new line();
        $npv_line->set_values($npv);
        $npv_line->set_width(2);
        $npv_line->set_colour('#ff6600');

        $x = new x_axis();
        $x->set_range(2005, 2060);
        $x->set_steps(10);

        $y = new y_axis();
        $y->set_range(-2000, 25000);
        $y->set_steps(2000);


        $chart = new open_flash_chart();
        $chart->set_title($title);
        $chart->add_element($realestateValue_line);
        $chart->add_element($returnBeforeTaxTotal_line);
        $chart->add_element($returnAfterTaxTotal_line);
        $chart->add_element($debtLeft_line);
        $chart->add_element($npv_line);
        $chart->set_x_axis($x);
        $chart->set_y_axis($y);

        echo $chart->toPrettyString();
    }
    function sestest1() {
        $this->load->library('ra_session');
        $this->ra_session->set_userdata('test', array('test!', 'waa'));
        echo date('H:m:s');
    }
    function sestest2() {
        $this->load->library('ra_session');
        var_dump($this->ra_session->userdata('test'));
    }
}
?>