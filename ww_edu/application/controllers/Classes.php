<?php
class Classes extends MY_Controller
{

	public function allProcess()
	{			
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
		$this->load->helper('struct');
		$this->load->helper('format');
		$this->load->helper('Trading_calculate');
		$this->load->library('classes_mission');

		$response = array('archive' => array('status' => 0,'message' =>'all mission complete'));
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
			$this->classes_mission->uid = $uid;
			$this->classes_mission->time = $original['personal']['u_time'];
			$homework = $this->classes_mission->init($mission, $personal, $allProcess)->get_distribution()->is_complete($is_complete)->get_mission_complete()->property('distributing')->get_homework();
			// print_r($homework);
			if ($homework !== false) {
				$this->saveRecord($uid, addslashes(json_encode($homework)));
			}

			$response = array('archive' => array('status' => 0,'message' =>'update mission'));
		}

		$data['data'] = [];
		encode_json($response,$data);
	}

	public function saveRecord($uid, $homework)
	{
		header( 'Access-Control-Allow-Origin:*' );
			
		$this->load->database();
		$this->load->model('ClassesM');
	
		return $this->ClassesM->saveRecord($uid, $homework);
	
	}

	public function current_stage()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ClassesM');
		$this->load->helper('struct');
		$this->load->helper('format');
		$this->load->helper('Trading_calculate');
		$this->load->library('classes_mission');

		$response = array('archive' => array('status' => 0 ,'message' =>''));
		$original = $this->ClassesM->current_stage($uid);
		$allProcess = $this->allProcess();
		$mission = $this->classes_mission->jsonDecode($original['mission']['homework']);
		$personal = $this->classes_mission->jsonDecode($original['personal']['homework']);

		$data['data']['complete'] = $this->classes_mission->init($mission, $personal, $allProcess)->generating()->get_mission_complete()->property('distributing')->complete_ratio();
		$data['data']['is_complete'] = $this->classes_mission->init($mission, $personal, $allProcess)->generating()->get_mission_complete()->property('distributing')->getOneComplete();

		$data['data']['current_stage'] = $original['personal']['hw_id'];
		$data['data']['title'] = $original['mission']['title'];
		$data['data']['describe'] = $original['mission']['describe'];
		$data['data']['detail'] = $this->classes_mission->init($mission, $personal, $allProcess)->lastOrNextProcess()->intersection();
		
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
		$this->load->helper('struct');
		$this->load->helper('format');
		$this->load->helper('Trading_calculate');
		$this->load->model('ClassesM');

		$this->load->library('classes_mission');

		$classes = $this->ClassesM->showStageDetail($stage_id);
		$mission = $this->classes_mission->jsonDecode($classes['homework']);
		$data['data']['title'] = $classes['title'];
		$data['data']['describe'] = $classes['describe'];
		$data['data']['detail'] = $this->classes_mission->init($mission)->lastOrNextProcess()->getLastOrNextProcess();

		$response = array('archive' => array('status' => 0,'message' =>''));
	
		encode_json($response,$data);
	}

	public function showAllStage()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->input->get_post('uid', TRUE);
		$admin_id = $this->get_byadmintoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('format');
		$this->load->helper('Trading_calculate');
		$this->load->library('classes_mission');
		$this->load->model('ClassesM');

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = [];
		
		$allProcess = $this->allProcess();
		$history = $this->show_history($uid);
		$original = $this->ClassesM->current_stage($uid);
		$history_homework = $this->classes_mission->jsonDecode($history['homework']);
		$mission = $this->classes_mission->jsonDecode($original['mission']['homework']);
		$personal = $this->classes_mission->jsonDecode($original['personal']['homework']);
		foreach ($history_homework as $key => $value) {
			$data['list']['_' . $key][] = $this->classes_mission->init($mission, $value, $allProcess)->generating()->get_mission_complete()->property('distributing')->getOneComplete();
		}
		$data['list']['_' . $original['personal']['hw_id']] = $this->classes_mission->init($mission, $personal, $allProcess)->generating()->get_mission_complete()->property('distributing')->getOneComplete();

		encode_json($response,$data);
	}

	public function show_history($uid)
	{			
		$this->load->database();
		$this->load->model('ClassesM');
	
		return $this->ClassesM->show_history($uid);
	}

	public function article_detail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$article_id = $this->input->get_post('article_id', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ClassesM');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->ClassesM->article_detail($article_id);
	
		encode_json($response,$data);
	}

}