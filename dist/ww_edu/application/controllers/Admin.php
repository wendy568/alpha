<?php
class Admin extends MY_Controller
{
	public function Login()
	{
		header( 'Access-Control-Allow-Origin:*' );
		$data = array();
		$username = $this->input->get_post('username', TRUE);
		$password = $this->input->get_post('password', TRUE);
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('admins');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->admins->login($username, $password, $response, $data);
		
		encode_json($response,$data);
	}
}