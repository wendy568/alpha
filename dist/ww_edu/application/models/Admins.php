<?php  

class Admins extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function login($username, $password, &$response, &$data)
	{
		$result = array();
		$map = 'SELECT id,password 
				FROM admin 
				WHERE username="'.$username.'"';	
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
				WHERE `admin_id`="'.$id.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		if(isset($result))
		{
			$map = 'UPDATE token 
					SET `token`="'.$hash.'" 
					WHERE `admin_id`="'.$id.'"';
			$this->db->query($map);
		}
		else
		{
			$map = 'INSERT token(token,admin_id) 
					VALUES("'.$hash.'","'.$id.'")';
			$this->db->query($map);
		}
		return $hash;
	}

	function get_bytoken($token)
	{
		$map = 'SELECT `admin_id` 
				FROM token 
				WHERE `token`="'.$token.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		if(!empty($result['admin_id']))
		{
			return $result['admin_id'];
		}
		else
		{
			header("Content-type: application/json");
			set_status_header(203);
			echo json_encode($response = array('archive' => array('status' => 400,'message' => 'Non-Authoritative Information')));
			exit(EXIT_USER_INPUT);
		}

	}

	function get_bytoken_id($token)
	{
		$map = 'SELECT a.`from_id` 
				FROM token t
				LEFT JOIN admin a 
				ON a.id=t.admin_id
				WHERE t.`token`="'.$token.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		
		return isset($result)?$result['from_id']:NULL;
	}

	function update($cols, &$response)
	{	
		$message = '';
		$status = 0;
		array_walk($cols, function($val, $key) use (&$message){
			if($this->db->query($val)){			
				$message .= "{$key} update success,";
			}else{
				$message .= "{$key} update failed,";
				$status = 39;
			}
		});
		$response = array('archive' => array('status' => $status,'message' =>substr($message, 0, -1)));
	}

	function add($cols, &$response)
	{	
		$message = '';
		$status = 0;
		array_walk($cols, function($val, $key) use (&$message){
			if($this->db->query($val)){			
				$message .= "{$key} add success,";
			}else{
				$message .= "{$key} add failed,";
				$status = 39;
			}
		});
		var_dump($response['archive']['message']);
		$response = array('archive' => array('status' => $status,'message' =>substr($message, 0, -1)));
	}

	function delete($id, $table)
	{
		$map = "DELETE FROM {$table} 
				WHERE id in (".$id.")";
		
		$this->db->query($map);
		$result = $this->db->affected_rows();
		return $result;
	}

}