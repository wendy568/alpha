<?php  

class Users extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function changePasswordFromForget($password, $email)
    {
    	$map = 'SELECT password  
    			FROM member
    			WHERE email="'.$email.'"';
    	
    	$result = $this->db->query($map)->row_array()['password'];

    	if (isset($result) && md5($password) == $result) {
    		header("Content-type: application/json");
			set_status_header(200);
			echo json_encode($response = array('archive' => array('status' => 21, 'message' => 'The new password is the same as the old one')));
			exit(EXIT_USER_INPUT);
    	}

    	$map = 'UPDATE member 
    			SET password="'.md5($password).'"
    			WHERE email="'.$email.'"';
    	
    	$this->db->query($map);
    	$result = $this->db->affected_rows();

    	return $result;
    }		

    function authorization($email, $code)
    {
    	$map = 'SELECT `time`  
    			FROM authentication_code
    			WHERE email="'.$email.'" AND code='.$code;
    	
    	$result = $this->db->query($map)->row_array()['time'];

    	if (isset($result)) {

    		if (time() - $result > 300) {
	    		header("Content-type: application/json");
				set_status_header(200);
				echo json_encode($response = array('archive' => array('status' => 405, 'message' => 'The verification code expired')));
				exit(EXIT_USER_INPUT);
    		}
    	} else {
    		
    		header("Content-type: application/json");
			set_status_header(200);
			echo json_encode($response = array('archive' => array('status' => 405, 'message' => 'Authentication Failed')));
			exit(EXIT_USER_INPUT);
    	}
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

	function add_trading_account($uid, $account)
	{
		$result = [];
		$map = 'INSERT trading_account(uid,account,c_time,`default`) 
				SELECT "'.$uid.'","'.$account.'","'.time().'", "1"
				FROM DUAL 
				WHERE NOT EXISTS (SELECT * FROM trading_account WHERE account="'.$account.'")';	
		$this->db->query($map);

	    $result = $this->db->insert_id();	
	}

	function userInfoCenter($id)
	{
		$map = 'SELECT m.face, m.email, m.phone, ui.first_name, ui.last_name, ui.major, ui.company, ui.school, ui.position, ui.country, ui.city  
				FROM member m 
				LEFT JOIN user_info ui
				ON  m.id=ui.mem_id 
				WHERE m.id="'.$id.'" ';
		
		$result = $this->db->query($map)->row_array();
		$result['face'] = json_decode($result['face']);

		return $result;
	}

	function userInfoCenterForAdmin($id)
	{
		$map = 'SELECT m.id, ta.account, m.face, m.email, m.phone, ui.first_name, ui.last_name, ui.major, ui.company, ui.school, ui.position, ui.country, ui.city, ui.birthdate, ui.age, ui.sex, m.user_type
				FROM member m 
				LEFT JOIN user_info ui
				ON  m.id=ui.mem_id 
				LEFT JOIN trading_account ta 
				ON ta.uid=m.id
				WHERE m.id="'.$id.'"
				AND ta.default=1';
		
		$result['BasicInfomation'] = $this->db->query($map)->row_array();
		$result['BasicInfomation']['face'] = json_decode($result['BasicInfomation']['face']);

		$map = 'SELECT account
				FROM trading_account
				WHERE uid="'.$id.'"';
		
		$result['MT4'] = $this->db->query($map)->result_array();

		$map = 'SELECT hw_id AS Level, COUNT(*) AS logs
				FROM homework h 
				LEFT JOIN trading_log tl
				ON tl.uid=h.uid
				WHERE h.uid="'.$id.'"';
		
		$result['Student'] = $this->db->query($map)->row_array();

		return $result;
	}

	function update_nic_name($id, $nic_name, &$response)
	{
		$map = 'SELECT nic_name,nic_name_verify_time 
				FROM member 
				WHERE id="'.$id.'"';
		
		$result = $this->db->query($map)->row_array();
		if (strlen($result['nic_name_verify_time'])>0) {
			if ($result['nic_name_verify_time']>time()) {
				$response['archive'] = array('status' => 213,'message' => '近半年内你才修改过昵称');
			} else {
				if ($result['nic_name'] == $nic_name) {
					$response = array('archive' => array('status' => 21,'message' =>'新昵称与旧昵称是相同的,珍惜修改次数'));
					return  FALSE;
				}
				$map = 'UPDATE member 
					SET nic_name="'.$nic_name.'",nic_name_verify_time="'.strtotime('+ 6 month').'" 
					WHERE id="'.$id.'"';
					$this->db->query($map);
		
				$response = array('archive' => array('status' => 0,'message' =>'success'));
			}
		} else {
			if ($result['nic_name'] == $nic_name) {
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

	function method($code)
	{
		$map = 'UPDATE authentication_code 
				SET code="'.$code.'"	
				WHERE email="'.$email.'"';
		
		$this->db->query($map);
		$result = $this->db->affected_rows();
	
		return $result;
	}		

	function add_authentication_code($email, $code)
	{
		$time = time();
		$map = 'SELECT code  
				FROM authentication_code
				WHERE email="'.$email.'"';
		
		$result = $this->db->query($map)->row_array()['code'];

		if (isset($result)) {
			$map = 'UPDATE authentication_code 
					SET code="'.$code.'" , time="'.$time.'"	
					WHERE email="'.$email.'"';
			
			$this->db->query($map);
			$result = $this->db->affected_rows();

		} else {

			$map = 'INSERT authentication_code(email,code,`time`) VALUES("'.$email.'","'.$code.'","'.$time.'")';	
			$this->db->query($map);
		    $result = $this->db->insert_id();

		}
		
	}

	function user_list($user_type, $start, $limit, &$count)
	{
		$where = " 1=1";
		$where .= (isset($user_type) && $user_type) ? " AND user_type={$user_type}" : null;
		var_dump($where);
		$map = "SELECT m.id, u.first_name, u.last_name, u.sex, u.age, u.country, m.email, m.phone, m.create_time, u.update_time
				FROM member m 
				LEFT JOIN user_info u 
				ON u.mem_id=m.id
				WHERE {$where}
				ORDER BY m.id DESC
				LIMIT {$start},{$limit}";
		
		$result = $this->db->query($map)->result_array();

		$map = "SELECT COUNT(*) AS count
				FROM member 
				{$where}";
		
		$count = $this->db->query($map)->row_array()['count'];

		return $result;
	}

	function MT4AccountList($start, $limit, &$count, $start_time, $end_time)
	{
		$where = " WHERE 1=1";

		if(isset($start_time) OR isset($end_time)) {
		    $start_time = ($start_time) ? $start_time : 0;
		    $end_time = ($end_time) ? $end_time : time();
		    $where .= " AND (c_time>{$start_time} AND c_time<{$end_time})";
		}

		$map = "SELECT ta.uid, ta.account, ui.first_name, ui.last_name, ta.c_time AS binding_time
				FROM trading_account ta 
				LEFT JOIN user_info ui 
				ON ui.mem_id=ta.uid
				{$where}
				LIMIT {$start},{$limit}";
		
		$result = $this->db->query($map)->result_array();

		$map = "SELECT COUNT(*) AS count
				FROM trading_account
				{$where}";
		
		$count = $this->db->query($map)->row_array()['count'];

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