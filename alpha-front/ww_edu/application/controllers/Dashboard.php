<?php
class Dashboard extends MY_Controller
{
	public function previews_since_today()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$xxxx = $this->input->get_post('xxxx', TRUE);
		$yyyy = $this->input->get_post('yyyy', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas();
		$this->load->library('trading_datas_calculate');
		print_r($this->trading_datas_calculate->build($mt4, 4, 2017)->datas_for_year()->datas_for_month()->get_property('profit'));die;
		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}
}