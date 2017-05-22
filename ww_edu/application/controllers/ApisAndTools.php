<?php
class ApisAndTools extends MY_Controller
{
	public function import_news()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$xxxx = $this->input->get_post('xxxx', TRUE);
		
		$this->load->database();
		$this->load->helper('help');
		$this->load->model('model');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->model->import_news($xxxx);
	
		encode_json($response,$data);
	}
}