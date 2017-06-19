<?php
class User extends MY_Controller
{
	public function Login()
	{
		header( 'Access-Control-Allow-Origin:*' );
		$data = array();
		// $username = $this->input->get_post('username', TRUE);
		$email = $this->input->get_post('email', TRUE);
		$password = $this->input->get_post('password', TRUE);
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->login->login($email, $password, $response, $data);
		
		encode_json($response,$data);
	}

	public function nic_name_isexists()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$nic_name = $this->input->get_post('nic_name', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->login->nic_name_isexists($nic_name, $response);
	
		encode_json($response,$data);
	}

	public function username_isexists()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$username = $this->input->get_post('username', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->login->username_isexists($username, $response);
	
		encode_json($response,$data);
	}

	public function register()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$first_name = $this->input->get_post('first_name', TRUE);
		$last_name = $this->input->get_post('last_name', TRUE);
		// $username = $this->input->get_post('username', TRUE);
		$email = $this->input->get_post('email', TRUE);
		$password = $this->input->get_post('password', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data = array();
		$this->login->register($email, md5($password), $response, $data, $first_name, $last_name);
		if($response['archive']['status'] === 0)
		{
			$str = $this->encode($email);
			$time = $this->encode(strtotime('+ 1 day'));
			$file = file_get_contents(ALPHATEXT.'verify.html');
			$title = 'AlphaTrader 邮箱验证消息';
			$this->load->helper('constants');
			$const = constants::build();
			$query = array(
					'referer' => $str,
					'verify' => $time
				);
			$list = array(
					'replaceName' => 'customer',
					'replaceUrl' => $const->alphatrader['base']['_pwd_site'].'?'.http_build_query($query)
				);
			array_walk($list, function ($item, $key) use (&$file){
				$file = str_replace($key, $item, $file);
			});

			$this->request_post('http://alphacoin.co.uk/mail.php',array(
				'title' => $title,
				'content' => $file,
				'email' => $email,
				'ssl' => $const->alphatrader['base']['ssl'],
			));
		}
		
		encode_json($response,$data);
	}

	public function user_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$admin_id = $this->get_byadmintoken($token);
		$user_type = $this->input->get_post('user_type', TRUE);
		$pages = $this->input->get_post('pages', TRUE);

		$start = 0;
		$limit = 30;
		$page_nums_per = 15;
		$count = 0;

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('pagination');
		$this->load->library('list_show');
		$this->load->model('users');
		
		$response = array('archive' => array('status' => 0, 'message' => ''));
		$data['data'] = [];

		$this->list_show->set_limit($pages, $start, $limit, $page_nums_per);
		$users = $this->users->user_list($user_type, $start, $limit, $count);
		$get_pagination = $this->list_show->set_array($users, $pages, $page_nums_per)->property('set_pages')->get_property();
		if ($get_pagination !== false) {
			$data['data'] = $get_pagination;
			$data['data']['interval'] = ceil($limit / $page_nums_per);
			$data['data']['page_nums_per'] = $page_nums_per;
			$data['data']['real_total_pages'] = ceil($count / $page_nums_per);
			$data['data']['real_total_nums'] = $count;
		} else {
			$response = array('archive' => array('status' => 204, 'message' => 'No Content'));
		}

		encode_json($response,$data);
	}

	public function userLayoutInfo()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
		$id = $this->get_bytoken($token);
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->login->userLayoutInfo($id);
	
		encode_json($response,$data);
	}

	public function userInfoCenterForAdmin()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->input->get_post('uid', TRUE);
		$admin_id = $this->get_byadmintoken($token);
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ClassesM');
		$this->load->helper('struct');
		$this->load->helper('format');
		$this->load->helper('Trading_calculate');
		$this->load->library('classes_mission');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$original = $this->ClassesM->current_stage($uid);
		$allProcess = $this->allProcess();
		$mission = $this->classes_mission->jsonDecode($original['mission']['homework']);
		$personal = $this->classes_mission->jsonDecode($original['personal']['homework']);

		$data['data'] = $this->getUserInfoById($uid);
		$is_complete = $this->classes_mission->init($mission, $personal, $allProcess)->generating()->get_mission_complete()->property('distributing')->getOneComplete();
		$data['data']['Student']['Task'] = 0;
		foreach ($is_complete as $val) {
			$data['data']['Student']['Task'] += $val;
		}
	
		encode_json($response,$data);
	}

	public function allProcess()
	{			
		$this->load->database();
		$this->load->model('ClassesM');
	
		return $this->ClassesM->allProcess();
	
	}

	public function getUserInfoById($uid)
	{		
		$this->load->database();
		$this->load->model('users');
	
		return $this->users->userInfoCenterForAdmin($uid);
	}

	public function userInfoCenter()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('users');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->userInfoCenter($mem_id);
	
		encode_json($response,$data);
	}

	public function updateUserInfo()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['mid'] = $this->get_bytoken($token);
		$datas['uid'] = $this->get_bytoken($token);

		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('sql_operation');
		$this->load->library('members');
		$this->load->database();
		$this->load->model('users');

		$cols = $this->members->init($datas)->format()->property('user_addslashes', [])->pickUpProperty()->update('face'); 

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->update($cols, $response);

		encode_json($response, $data);
	}

	public function MT4AccountList()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$admin_id = $this->get_byadmintoken($token);
		$pages = $this->input->get_post('pages', TRUE);

		$start = 0;
		$limit = 10;
		$page_nums_per = 5;
		$count = 0;

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('pagination');
		$this->load->library('list_show');
		$this->load->model('users');
		
		$response = array('archive' => array('status' => 0, 'message' => ''));
		$data['data'] = [];

		$this->list_show->set_limit($pages, $start, $limit, $page_nums_per);
		$users = $this->users->MT4AccountList($start, $limit, $count);
		$get_pagination = $this->list_show->set_array($users, $pages, $page_nums_per)->property('set_pages')->get_property();
		if ($get_pagination !== false) {
			$data['data'] = $get_pagination;
			$data['data']['interval'] = ceil($limit / $page_nums_per);
			$data['data']['page_nums_per'] = $page_nums_per;
			$data['data']['real_total_pages'] = ceil($count / $page_nums_per);
			$data['data']['real_total_nums'] = $count;
		} else {
			$response = array('archive' => array('status' => 204, 'message' => 'No Content'));
		}

		encode_json($response,$data);
	}

	public function add_trading_account()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		$account = $this->input->get_post('account', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('users');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = [];
		$this->users->add_trading_account($mem_id, $account);
	
		encode_json($response,$data);
	}

	public function update_nic_name()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$nic_name = $this->input->get_post('nic_name', TRUE);
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('users');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->users->update_nic_name($mem_id, $nic_name, $response);
	
		encode_json($response,$data);
	}

	public function change_password()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$pwd_old = md5($this->input->get_post('pwd_old', TRUE));
		$pwd_new = md5($this->input->get_post('pwd_new', TRUE));
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('users');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->users->change_password($pwd_new, $pwd_old, $mem_id, $response);
	
		encode_json($response,$data);
	}

	public function send_mail()
	{
		$email = $this->input->get_post('email', TRUE);
		$nic_name = $this->input->get_post('nic_name', TRUE);
		$str = $this->encode($email);
		$time = $this->encode(strtotime('+ 1 day'));
		$file = file_get_contents(ALPHATEXT.'verify.html');
		$title = 'AlphaTrader 邮箱验证消息';
		$this->load->helper('constants');
		$const = constants::build();
		$query = array(
				'referer' => $str,
				'verify' => $time
			);
		$list = array(
				'replaceName' => $nic_name,
				'replaceUrl' => $const->alphatrader['base']['_pwd_site'].'?'.http_build_query($query)
			);
		array_walk($list, function ($item, $key) use (&$file){
			$file = str_replace($key, $item, $file);
		});

		$this->request_post('http://alphacoin.co.uk/mail.php',array(
			'title' => $title,
			'content' => $file,
			'email' => $email,
			'ssl' => $const->alphatrader['base']['ssl'],
		));
	}

	public function change_account()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$account = $this->input->get_post('account', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('users');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->users->change_account($uid, $account);
		$data['data'] = [];

		encode_json($response,$data);
	}

	public function update()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['from_id'] = $this->get_bytoken($token);
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['content'])) $datas['content'] = addslashes($datas['content']);
		if(!empty($datas['title'])) $datas['title'] = addslashes($datas['title']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);
		if(!empty($datas['act_info'])) $datas['act_info'] = addslashes($datas['act_info']);

		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$image = null;

		if(!empty($datas['width']) && !empty($datas['height'])) $image = get_image($datas['width'], $datas['height'], "{$datas['file_path']}");
		if($image) $datas['image'] = addslashes(json_encode(array("{$datas['file_path']}/".json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));

		$dfdb = databases_filter::build();
		$cols = array($datas['table']);

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->update_complete($cols, array($datas['table']=>array('id'=>$datas['id'])));
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->update($cols, $response);

		encode_json($response, $data);
	}

	public function add()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['from_id'] = $this->get_bytoken($token);
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['content'])) $datas['content'] = addslashes($datas['content']);
		if(!empty($datas['title'])) $datas['title'] = addslashes($datas['title']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);
		if(!empty($datas['act_info'])) $datas['act_info'] = addslashes($datas['act_info']);

		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$image = null;

		if(!empty($datas['width']) && !empty($datas['height'])) $image = get_image($datas['width'], $datas['height'], "{$datas['file_path']}");
		if($image) $datas['image'] = addslashes(json_encode(array("{$datas['file_path']}/".json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));

		$dfdb = databases_filter::build();
		$cols = array($datas['table']);

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->insert_complete($cols);
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->add($cols, $response);

		encode_json($response, $data);
	}
}








