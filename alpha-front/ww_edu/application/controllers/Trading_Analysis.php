<?php
class Trading_Analysis extends MY_Controller
{
	public function trading_previews()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$xxxx = $this->input->get_post('xxxx', TRUE);
		$yyyy = $this->input->get_post('yyyy', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('tradinganalysis');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->tradinganalysis->trading_previews($xxxx, $yyyy);
	
		encode_json($response,$data);
	}
}