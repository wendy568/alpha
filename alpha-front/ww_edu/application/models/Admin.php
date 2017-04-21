<?php  

class Admin extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function check_account($username, $password)
	{
		$result = array();
		$map = 'SELECT `id` 
				FROM admin 
				WHERE `username`="'.$username.'" 
				AND `password`="'.$password.'"';	
		$query = $this->db->query($map);
        $result = $query->row_array();
        if(isset($result))
        {
        	$this->get_token($result['id']);
        	return $password;
        }
        else
        {
        	return FALSE;
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
		$_SESSION['admin_id'] = $hash;
	}

	function get_bytoken($token)
	{
		$map = 'SELECT `admin_id` 
				FROM token 
				WHERE `token`="'.$token.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		if(isset($result))
		{
			$map = 'SELECT `nic_name` 
				FROM admin 
				WHERE `id`="'.$result['admin_id'].'"';
		
			$query = $this->db->query($map);
			$result = $query->row_array();
			return $result['nic_name'];
		}
		else
		{
			return FALSE;
		}
	}
}