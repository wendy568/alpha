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

	function userInfoCenter($id)
	{
		$map = 'SELECT m.face, m.email, m.phone, ui.first_name, ui.last_name, ui.major, ui.company, ui.school, ui.position, ui.country, ui.city  
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
			$response['archive'] = $result ? array('status' => 0,'message' =>'success') : array('status' => 21,'message' =>'新口令与旧口令相同');

			return false;
		}

		$response['archive'] = array('status' => 103,'message' =>'密码错误');
	}

	function user_list($user_type, $start, $limit)
	{
		$start = $start?$start:0;
		$limit = $limit?$limit:500;

		$map = "SELECT u.first_name, u.last_name, u.sex, u.age, u.country, m.email, m.phone 
				FROM member m 
				LEFT JOIN user_info u 
				ON u.mem_id=m.id
				WHERE user_type={$user_type}
				LIMIT {$start},{$limit}";
		
		$result = $this->db->query($map)->result_array();
		return $result;
	}

	function change_account($uid, $account)
	{
		$map = 'UPDATE trading_account 
				SET `default`=0
				WHERE uid="'.$uid.'"';
		
		$this->db->query($map);

		$map = 'UPDATE trading_account 
				SET `default`=1
				WHERE uid="'.$uid.'" 
				AND account="'.$account.'"';
		
		$this->db->query($map);
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

	function iteration_update($cols, &$update_count)
	{	
		$message = '';
		$status = 0;
		$count = 1;

		array_walk($cols, function($val, $key) use (&$message, &$count, &$update_count){
			if($this->db->query($val)){
				$update_count += $count;
				$message = "{$key} update success {$update_count}(s),";
			}else{
				$message .= "{$key} update failed, 「 {$val} 」,";
			}
		});
		
		return substr($message, 0, -1);
	}

	function iteration_add($cols, &$update_count)
	{	
		$message = '';
		$status = 0;
		$count = 1;

		array_walk($cols, function($val, $key) use (&$message, &$count, &$update_count){
			if($this->db->query($val)){
				$update_count += $count;
				$message = "{$key} add success {$update_count}(s),";
			}else{
				$message .= "{$key} add failed, 「 {$val} 」,";
			}
		});
		
		return substr($message, 0, -1);
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