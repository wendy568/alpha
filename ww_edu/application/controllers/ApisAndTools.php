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
		$this->load->helper('sql_operation');
		$this->load->helper('struct');
		$this->load->helper('format');
		$this->load->library('insert_update_api');
		$this->load->helper('json');
		$this->load->model('TradingAnalysis');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$count = 0;
		$calendars_before = $this->TradingAnalysis->calendarForApi();
		$data['data']['update'] = $this->insert_update_api->init($calendar, $calendars_before)->property('comparison', ['md5', 'id'])->iteration_update('calendar', $count);
		$count = 0;
		$data['data']['add'] = $this->insert_update_api->iteration_add('calendar', $count);
	
		encode_json($response,$data);
	}

	public function saveForNews()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$news = $this->input->get_post('news', TRUE);
		
		$this->load->database();
		$this->load->helper('sql_operation');
		$this->load->helper('struct');
		$this->load->helper('format');
		$this->load->library('insert_update_api');
		$this->load->helper('json');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$count = 0;
		$data['data']['add'] = $this->insert_update_api->init($news)->iteration_add('news', $count);
	
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