<?php  

class Users extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function email_verify($email)
	{
		$map = 'UPDATE member 
				SET email_identified=1 
				WHERE email="'.$email.'"';
		
		$this->db->query($map);
		$result = $this->db->affected_rows();
	
		return $result;
	}

	function user_info_center($id)
	{
		$map = 'SELECT m.email, m.phone, ui.full_name, ui.pro, ui.organization,ui.tradingplatform 
				FROM member m 
				LEFT JOIN user_info ui
				ON  m.id=ui.mem_id 
				WHERE m.id="'.$id.'" ';
		
		$result = $this->db->query($map)->row_array();
		return $result;
	}

	function update_nic_name($id, $nic_name, &$response)
	{
		$map = 'SELECT nic_name,nic_name_verify_time 
				FROM member 
				WHERE id="'.$id.'"';
		
		$result = $this->db->query($map)->row_array();
		if(strlen($result['nic_name_verify_time'])>0){
			if($result['nic_name_verify_time']>time()){
				$response['archive'] = array('status' => 213,'message' => '近半年内你才修改过昵称');
			}else
			{
				if($result['nic_name'] == $nic_name)
				{
					$response = array('archive' => array('status' => 21,'message' =>'新昵称与旧昵称是相同的,珍惜修改次数'));
					return  FALSE;
				}
				$map = 'UPDATE member 
					SET nic_name="'.$nic_name.'",nic_name_verify_time="'.strtotime('+ 6 month').'" 
					WHERE id="'.$id.'"';
					$this->db->query($map);
		
				$response = array('archive' => array('status' => 0,'message' =>'success'));
			}
		}else{
			if($result['nic_name'] == $nic_name)
			{
				$response = array('archive' => array('status' => 21,'message' =>'新昵称与旧昵称是相同的,珍惜修改次数'));
				return  FALSE;
			}
			$map = 'UPDATE member 
					SET nic_name="'.$nic_name.'",nic_name_verify_time="'.strtotime('+ 6 month').'" 
					WHERE id="'.$id.'"';
					$this->db->query($map);
		
			$response = array('archive' => array('status' => 0,'message' =>'success'));
		}
		
	}

	function change_password($pwd_new, $pwd_old, $mem_id, &$response)
	{
		$map = 'SELECT password 
				FROM member
				WHERE id="'.$mem_id.'"';
		
		$result = $this->db->query($map)->row_array();
		if ($result['password'] == $pwd_old) {
			$map = 'UPDATE member 
					SET password="'.$pwd_new.'" 
					WHERE id="'.$mem_id.'"';
			
			$this->db->query($map);
			$result = $this->db->affected_rows();
			$response['archive'] = $result?array('status' => 0,'message' =>'success'):array('status' => 21,'message' =>'新口令与旧口令相同');
			return FALSE;
		}

		$response['archive'] = array('status' => 103,'message' =>'密码错误');
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
		$response = array('archive' => array('status' => $status,'message' =>substr($message, 0, -1)));
	}

}