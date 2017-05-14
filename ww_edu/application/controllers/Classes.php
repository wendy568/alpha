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

		$mission = $this->classes_mission->jsonDecode($original['mission']['homework']);
		$personal = $this->classes_mission->jsonDecode($original['personal']['homework']);
		$data['data']['complete'] = $this->classes_mission->init($mission, $personal)->get_mission_complete()->property('distributing')->complete_ratio();
		$showData = $this->classes_mission->init($mission, $personal)->showData;

		foreach ($showData as $key => $value) {
			if (!empty($mission[$key])) {
				foreach ($mission[$key] as $k) {
					print_r($mission[$key]);die;
					// $mission[$key][$k] = $this->showData($k, $value);
				}
			}
		}
		$data['data']['current_stage'] = $mission;
		
		encode_json($response,$data);
	}

	public function showData($ids, $table)
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->database();
		$this->load->model('ClassesM');
	
		$response = array('archive' => array('status' => 0,'message' =>''));

		return $this->ClassesM->showData($ids, $table);
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