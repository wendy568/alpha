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

	public function saveForCalendar()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$calendar = $this->input->get_post('calendar', TRUE);
		
		$this->load->database();
		$this->load->library('insert_update_api.php');
		$this->load->helper('json');
		$this->load->model('Toolfordis');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		 $this->insert_update_api.php->init();
		$data['data'] = $this->Toolfordis->saveForCalendar($calendar);
	
		encode_json($response,$data);
	}

	public function saveUpdateNews()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$news = $this->input->get_post('news', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Toolfordis');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Toolfordis->saveUpdateNews($news);
	
		encode_json($response,$data);
	}

	public function test()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Toolfordis');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Toolfordis->test();
	
		encode_json($response,$data);
	}
}