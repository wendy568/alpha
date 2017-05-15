<?php
class Classes extends MY_Controller
{

	public function allProcess()
	{
		header( 'Access-Control-Allow-Origin:*' );
			
		$this->load->database();
		$this->load->model('ClassesM');
	
		return $this->ClassesM->allProcess();
	
	}

	public function record_process()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$article_classes_id = $this->input->get_post('article_classes_id', TRUE);
		$look_up = $this->input->get_post('look_up', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->get_bytoken($token);
		$account = $this->get_account($uid);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ClassesM');
		$this->load->helper('format');
		$this->load->helper('struct');
		$this->load->library('classes_mission');

		$response = array('archive' => array('status' => 0,'message' =>''));
		$original = $this->ClassesM->current_stage($uid);
		$allProcess = $this->allProcess();
		
		$mission = $this->classes_mission->jsonDecode($original['mission']['homework']);
		$personal = $this->classes_mission->jsonDecode($original['personal']['homework']);
		$ratio = $this->classes_mission->init($mission, $personal, $allProcess)->generating()->get_mission_complete()->property('distributing')->complete_ratio();

		if($ratio != 1) {
			$is_complete = $this->classes_mission->init($mission, $personal, $allProcess)->generating()->get_mission_complete()->property('distributing')->getOneComplete();
			$this->classes_mission->public_params = $article_classes_id;
			$this->classes_mission->look_up = $look_up;
			$this->classes_mission->account = $account;
			$homework = $this->classes_mission->init($mission, $personal, $allProcess)->get_distribution()->is_complete($is_complete)->get_mission_complete()->property('distributing');
			die;
			if ($homework !== false) {
				$this->saveRecord($homework);
			}
			
		}
		
		encode_json($response,$data);
	}

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

		$response = array('archive' => array('status' => 0 ,'message' =>''));
		$original = $this->ClassesM->current_stage($uid);
		$allProcess = $this->allProcess();
		$mission = $this->classes_mission->jsonDecode($original['mission']['homework']);
		$personal = $this->classes_mission->jsonDecode($original['personal']['homework']);

		$data['data']['complete'] = $this->classes_mission->init($mission, $personal, $allProcess)->generating()->get_mission_complete()->property('distributing')->complete_ratio();
		$data['data']['is_complete'] = $this->classes_mission->init($mission, $personal, $allProcess)->generating()->get_mission_complete()->property('distributing')->getOneComplete();

		$data['data']['current_stage'] = $original['personal']['hw_id'];
		$data['data']['describe'] = $original['mission']['describe'];
		$data['data']['detail'] = $this->classes_mission->init($mission, $personal, $allProcess)->lastOrNextProcess()->intersection($mission, $personal);
		
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

}