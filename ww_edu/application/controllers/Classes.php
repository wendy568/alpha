<?php
class Classes extends MY_Controller
{

	public function current_stage()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ClassesM');
		$this->load->helper('format');
		$this->load->helper('struct');
		$this->load->library('classes_mission');

		$response = array('archive' => array('status' => 0,'message' =>''));
		$original = $this->ClassesM->current_stage($uid);
		$data['data']['current_stage'] = $this->classes_mission->jsonDecode($original['personal']['homework']);
		$data['data']['process'] = $this->classes_mission->init($data['data']['current_stage'], $this->classes_mission->jsonDecode($original['mission']['homework']))->property('viewVideo')->get_property();
		encode_json($response,$data);
	}

	public function All_stages()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ClassesM');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->ClassesM->All_stages();
	
		encode_json($response,$data);
	}

	public function showStageDetail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$stage_id = $this->input->get_post('stage_id', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ClassesM');

		// $this->load->helper('struct');
		// $this->load->helper('sql_operation');
		$this->load->library('classes');

		$classes = $this->ClassesM->showStageDetail($stage_id, $uid);
		$this->classes->init($classes, $homework);
		$data['data'] = [];

		$response = array('archive' => array('status' => 0,'message' =>''));
	
		encode_json($response,$data);
	}

	public function feedBackVideoId()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$stage_id = $this->input->get_post('stage_id', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ClassesM');

		// $this->load->helper('struct');
		// $this->load->helper('sql_operation');
		$this->load->library('classes');

		$classes = $this->ClassesM->showStageDetail($stage_id, $uid);
		$this->classes->init($classes, $homework);
		$data['data'] = [];

		$response = array('archive' => array('status' => 0,'message' =>''));
	
		encode_json($response,$data);
	}
}