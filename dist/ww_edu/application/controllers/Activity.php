<?php
class Activity extends MY_Controller
{
	public function Activity_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$xxxx = $this->input->get_post('xxxx', TRUE);
		$yyyy = $this->input->get_post('yyyy', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Activities');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Activities->Activity_list($xxxx, $yyyy);
	
		encode_json($response,$data);
	}
}