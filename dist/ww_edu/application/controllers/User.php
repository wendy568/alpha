<?php
class User extends MY_Controller
{
	public function Login()
	{
		header( 'Access-Control-Allow-Origin:*' );
		setcookie("name","value",time());
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

	public function get_bytoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken($token);
		return $data;
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

		// $first_name = $this->input->get_post('first_name', TRUE);
		// $last_name = $this->input->get_post('last_name', TRUE);
		// $username = $this->input->get_post('username', TRUE);
		$email = $this->input->get_post('email', TRUE);
		$password = $this->input->get_post('password', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data = array();
		$this->login->register($email, md5($password), $response, $data);
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

	public function sign_out()
	{
		header( 'Access-Control-Allow-Origin:*' );
		$token = $this->input->get_post('token', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
		
		$data['data'] = array();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->login->sign_out($token, $response);
	
		encode_json($response,$data);
	}

	public function user_layout_info()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
		$id = $this->get_bytoken($token);
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->login->user_layout_info($id);
	
		encode_json($response,$data);
	}

	public function user_info_center()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('users');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->user_info_center($mem_id);
	
		encode_json($response,$data);
	}

	public function update_user_info()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['mem_id'] = $this->get_bytoken($token);
		$datas['id'] = $this->get_bytoken($token);
		if(!empty($datas['first_name'])) $datas['first_name'] = addslashes($datas['first_name']);
		if(!empty($datas['last_name'])) $datas['last_name'] = addslashes($datas['last_name']);
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
		$cols = array('member', 'user_info');

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->update_complete(
			 	$cols, array('member' => array('id'=> $datas['id']),
			 				 'user_info' => array('mem_id' => $datas['mem_id'])
			 			));
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->update($cols, $response);

		encode_json($response, $data);
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








