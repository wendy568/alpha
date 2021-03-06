<?php
class Trading_log extends MY_Controller
{
	public function show_trading_logs()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Trading_logs');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Trading_logs->show_trading_logs();
	
		encode_json($response,$data);
	}

	public function test()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$uu = $this->input->get_post('uu', TRUE);
		$sign = $this->input->get_post('sign', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Trading_logs');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Trading_logs->test($uu, $sign);
	
		encode_json($response,$data);
	}
}