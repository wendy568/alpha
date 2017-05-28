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
		$this->load->model('TradingAnalysis');
		$mt4 = $this->TradingAnalysis->export_mt4_datas();
		$this->load->library('trading_datas_calculate');
		print_r($this->trading_datas_calculate->build($mt4)->trading_count());die;
		$response = array('archive' => array('status' => 0,'message' =>''));
	
		encode_json($response,$data);
	}
}