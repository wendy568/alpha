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
		$this->load->library('Trading_datas_calculate');
		print_r($this->Trading_datas_calculate);die;
		$this->load->model('Dashboards');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Dashboards->previews_since_today($xxxx, $yyyy);
	
		encode_json($response,$data);
	}
}