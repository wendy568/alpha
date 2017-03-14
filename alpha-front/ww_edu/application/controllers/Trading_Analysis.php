<?php
class Trading_Analysis extends MY_Controller
{
	public function calculator_anytime()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($finency_proc);
		$this->load->library('trading_datas_calculate');
		$data['data']['risk_management_level'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('variance', ['profit'])->get_property();
		$data['data']['operating_frequecy'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('frequency', ['avg_deviation', ['order_open_time', 'order_close_time']])->get_property();
		$data['data']['operating_accuracy'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('accuracy', ['profit'])->get_property();
		$data['data']['trading_ability'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('ability', ['profit'])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}

	public function profit_loss()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($finency_proc);
		$this->load->library('trading_datas_calculate');
		// $data['data']['profit_total'] = $this->trading_datas_calculate->build($mt4, 3)->property('sum', ['profit'])->get_property();
		$data['data']['profit'] = $this->trading_datas_calculate->build($mt4, 3)->saveCountPositive('profit')->property('sum', ['profit'])->get_property();
		// $data['data']['loss'] = $this->trading_datas_calculate->build($mt4, 3)->get_day()->count()->property('get_count', [])->get_property();

		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}
}