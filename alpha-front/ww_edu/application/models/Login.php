<?php  

class Login extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function login($email, $password, &$response, &$data)
	{
		$result = array();
		$map = 'SELECT id,password 
				FROM member 
				WHERE email="'.$email.'"';	
		$query = $this->db->query($map);
        $result = $query->row_array();

        if(isset($result))
        {
        	$hash = password_hash($result['password'], PASSWORD_BCRYPT);
	    	if (password_verify(md5($password), $hash))
	    	{
	    		$token = $this->get_token($result['id']);
				$response = array('archive' => array('status' => 0,'message' =>'登录成功'));
				$data['data']['token'] = $token;
				// $data['data']['direct'] = "http://localhost:8080/webpack-dev-server/";
			}
			else 
			{
				$response = array('archive' => array('status' => 101,'message' =>'密码或者账号错误'));
				$data['data'] = [];
			}
        }
        else
        {
				$response = array('archive' => array('status' => 101,'message' =>'密码或者账号错误'));
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
		if(isset($result))
		{
			$map = 'UPDATE token 
					SET `token`="'.$hash.'" 
					WHERE `mem_id`="'.$id.'"';
			$this->db->query($map);
		}
		else
		{
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
		if(isset($result))
		{
			return $result['mem_id'];
		}
		else
		{
			header("Content-type: application/json");
			set_status_header(203);
			echo json_encode($response = array('archive' => array('status' => 400,'message' => 'Non-Authoritative Information')));
			exit(EXIT_USER_INPUT);
		}

	}

	function get_trading_account($uid)
	{
		print_r($uid);die;
		$map = 'SELECT account  
				FROM trading_account
				WHERE uid="'.$uid.'"';
		
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

	function nic_name_isexists($nic_name, &$response) 
	{
		$map = 'SELECT id 
				FROM member 
				WHERE nic_name="'.$nic_name.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		$response = $result['id']?array('archive' => array('status' => 100,'message' =>'nicname is exists!')):array('archive' => array('status' => 0,'message' =>''));
	}

	function username_isexists($username, &$response) 
	{
		$map = 'SELECT id 
				FROM member 
				WHERE username="'.$username.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		$response = $result['id']?array('archive' => array('status' => 100,'message' =>'username is exists!')):array('archive' => array('status' => 0,'message' =>''));
	}

	function register($email, $password, &$response, &$data)
	{
		$e = $this->email_isexists($email);
		if($e)
		{
			$response = array('archive' => array('status' => 102,'message' =>'email is exists!'));
			return false;
		}
		$result = array();
		$map = 'INSERT member(email,password,create_time) VALUES("'.$email.'","'.$password.'","'.date('Y-m-d H:i:s',time()).'")';
		$this->db->query($map);
	    $result = $this->db->insert_id();
	    $map = 'INSERT user_info(mem_id) VALUES("'.$result.'")';
	    $this->db->query($map);
	    $token = $this->get_token($result);
	    $data['data']['token'] = $token;
	}

	function email_isexists($email)
	{
		$map = 'SELECT id 
				FROM member 
				WHERE email="'.$email.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		return $result['id']?TRUE:FALSE;
	}

	function user_layout_info($id)
	{
		$map = 'SELECT face, email
				FROM member
				WHERE id="'.$id.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		return $result;
	}

	function sign_out($token, &$response)
	{
		$map = 'DELETE FROM token 
				WHERE token="'.$token.'"';
		
		$query = $this->db->query($map);
		$count = $this->db->affected_rows();
		$response = $count?array('archive' => array('status' => 0,'message' =>'success')):array('archive' => array('status' => 31,'message' =>'登出失败，产生此错误有部分人为原因，如果你怀疑帐号不够安全，请尽快修改密码'));
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













