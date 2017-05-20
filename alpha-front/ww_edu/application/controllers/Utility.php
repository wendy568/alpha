<?php
class Utility extends MY_Controller
{

	public function get_bytoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken($token);
		return $data;
	}
	
	public function ranking_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
			
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('toolfordis');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->toolfordis->ranking_list();
	
		encode_json($response,$data);
	}

	public function get_unix_time()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$ip = $this->input->ip_address();
		
		$data['data'] = time();
	
		$response = array('archive' => array('status' => 0,'message' =>''));
	
		encode_json($response,$data);
	}
}


