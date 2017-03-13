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
			$response = array('archive' => array('status' => 400,'message' =>'请重新登陆'),'data'=>$token);
			echo json_encode($response);
			exit;
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

}