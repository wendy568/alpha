<?php  

class Login extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function login($account, $password, &$response, &$data)
	{
		$pos = strpos($account, '@');
		if ($pos === false) {
			$result = array();
			$map = 'SELECT *
					FROM member 
					WHERE username="'.$account.'"';	
		} else {
			$result = array();
			$map = 'SELECT *
					FROM member 
					WHERE email="'.$account.'"';	
		}

		$query = $this->db->query($map);
        $result = $query->row_array();

        if(isset($result)) {
        	$hash = password_hash($result['password'], PASSWORD_BCRYPT);
	    	if (password_verify(md5($password), $hash)) {
	    		$token = $this->get_token($result['id']);
				$response = array('archive' => array('status' => 0,'message' =>'Login Success'));
				$data['data']['token'] = $token;
				// $data['data']['direct'] = "http://localhost:8080/webpack-dev-server/";
			} else {
				$response = array('archive' => array('status' => 101,'message' =>'account or password is invalid'));
				$data['data'] = [];
			}
        } else {
			$response = array('archive' => array('status' => 101,'message' =>'account or password is invalid'));
			$data['data'] = [];
        }

	}

	function get_token($id)
	{
		$bcrypt = 'adauKJNAIUjasdai76768ADAkj09hjhGHAB';
		$hash = password_hash($bcrypt.$id,PASSWORD_BCRYPT);
		$map = 'SELECT `token` 
				FROM token 
				WHERE `mem_id`="'.$id.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		if(isset($result)) {
			$map = 'UPDATE token 
					SET `token`="'.$hash.'" 
					WHERE `mem_id`="'.$id.'"';
			$this->db->query($map);
		} else {
			$map = 'INSERT token(token,mem_id) 
					VALUES("'.$hash.'","'.$id.'")';
			$this->db->query($map);
		}
		return $hash;
	}

	function get_bytoken($token)
	{
		$map = 'SELECT `mem_id` 
				FROM token 
				WHERE `token`="'.$token.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		if(isset($result)) {
			return $result['mem_id'];
		}
		else {
			header("Content-type: application/json");
			set_status_header(203);
			echo json_encode($response = array('archive' => array('status' => 400,'message' => 'Non-Authoritative Information')));
			exit(EXIT_USER_INPUT);
		}

	}

	function get_trading_account($uid)
	{
		$map = 'SELECT account  
				FROM trading_account
				WHERE uid="'.$uid.'" 
				AND `default`=1';
		
		$result = $this->db->query($map)->row_array();
		return isset($result['account']) ? $result['account'] : null;
	}

	function get_bytoken_id($token)
	{
		$map = 'SELECT `mem_id` 
				FROM token 
				WHERE `token`="'.$token.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		
		return isset($result)?$result['mem_id']:NULL;
	}

	function nic_name_isexists($nic_name) 
	{
		$map = 'SELECT id 
				FROM member 
				WHERE nic_name="'.$nic_name.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();

		return $result['id'] ? TRUE : FALSE;
	}

	function email_isexists($email)
	{
		$map = 'SELECT id 
				FROM member 
				WHERE email="'.$email.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();

		return $result['id'] ? TRUE : FALSE;
	}

	function username_isexists($username) 
	{
		$map = 'SELECT id 
				FROM member 
				WHERE username="'.$username.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();

		return $result['id'] ? TRUE : FALSE;
	}

	function register($email, $password, &$response, &$data, $first_name, $last_name, $username, $birthdate, $sex)
	{
		$e = $this->email_isexists($email);
		if($e) {
			$response = array('archive' => array('status' => 102,'message' =>'email is exists!'));
			return false;
		}

		$u_n = $this->username_isexists($username);
		if($u_n) {
			$response = array('archive' => array('status' => 102,'message' =>'username is exists!'));
			return false;
		}

		$result = array();
		$map = 'INSERT member(email,password,create_time,username) VALUES("'.$email.'","'.$password.'","'.date('Y-m-d H:i:s',time()).'","'.$username.'")';
		$this->db->query($map);
	    $result = $this->db->insert_id();
	    $map = 'INSERT user_info(mem_id, first_name, last_name, birthdate, sex) VALUES("'.$result.'","'.$first_name.'","'.$last_name.'","'.$birthdate.'","'.$sex.'")';
	    $this->db->query($map);
	    $map = 'INSERT homework(uid,create_time,update_time,c_time,u_time) VALUES("'.$result.'","'.date('Y-m-d H:i:s', time()).'","'.date('Y-m-d H:i:s', time()).'","'.time().'","'.time().'")';
	    $this->db->query($map);
	    $map = 'INSERT homework_history(uid,homework) VALUES("'.$result.'","{}")';
	    $this->db->query($map);
	    $token = $this->get_token($result);
	    $data['data']['token'] = $token;
	}

	function userLayoutInfo($id)
	{
		$map = 'SELECT face, first_name, last_name, username 
				FROM member m
				LEFT JOIN user_info u
				ON u.mem_id=m.id
				WHERE m.id="'.$id.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		$result['face'] = json_decode($result['face']);
		return $result;
	}

	function change_password($password, $email, &$response, &$data)
	{
		$map = 'UPDATE member 
				SET password="'.md5($password).'" 
				WHERE email="'.$email.'"';
		$query = $this->db->query($map);
		$count = $this->db->affected_rows();
		$response = $count?array('archive' => array('status' => 0,'message' =>'success')):array('archive' => array('status' => 21,'message' =>'old password and new password are the same'));
		$data['data']['token'] = [];

	}		

}













