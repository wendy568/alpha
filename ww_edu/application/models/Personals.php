<?php  

class Personals extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }
    
    function update_comment_like($dis_id, $like, $num)
    {
    	$map = 'UPDATE comment 
    			SET `'.$like.'`=`'.$like.'`+'.$num.'  
    			WHERE dis_id="'.$dis_id.'"';
    	
    	$query = $this->db->query($map);
    }

    function update_face($id, $face, &$response, &$data)
	{
		$map = 'SELECT face 
    			FROM member
    			WHERE id="'.$id.'"';
    	
    	$result = $this->db->query($map)->row_array();
    	if($old_face = json_decode($result['face'], TRUE))
    	{
    		array_map('unlink', glob("upload/{$old_face[0]}/*{$old_face[1]}"));
    	}

		$map = 'UPDATE member 
				SET face="'.$face.'"
				WHERE id="'.$id.'"';
		
		$this->db->query($map);
		$result = $this->db->affected_rows();

		$response = $result?$response:array('archive' => array('status' => 0,'message' =>'no change'));
	}				

	function save($code,$ip)
	{
		$map = 'SELECT count(*) as count 
				FROM captcha
				WHERE ip="'.$ip.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		if($result['count'])
		{
			$map = 'UPDATE captcha 
				SET code="'.$code.'"
				WHERE ip="'.$ip.'"';
		
			$query = $this->db->query($map);
		}
		else
		{
			$result = array();
			$map = 'INSERT captcha(code,ip) VALUES("'.$code.'","'.$ip.'")';	
			$query = $this->db->query($map);
		}
	}

	function get_code($ip)
	{
		$map = 'SELECT code 
				FROM captcha
				WHERE ip="'.$ip.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		return $result['code'];
	}

	function follow_mem($mem_id, $from_id, &$response, $stas)
	{
		$result = array();
		$map = 'SELECT count(*) as count 
				FROM follow
				WHERE mem_id="'.$mem_id.'" and from_id='.$from_id;
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		if(!$result['count'])
		{
			$map = 'INSERT follow(mem_id,from_id) VALUES("'.$mem_id.'","'.$from_id.'")';
			$stas->statistic($mem_id,1,'follow');
			$query = $this->db->query($map);

		    return 'success';
		}

		$map = 'DELETE FROM follow 
				WHERE mem_id="'.$mem_id.'"and from_id='.$from_id;
		$stas->statistic($mem_id,1,'cancel_follow');
		$query = $this->db->query($map);

		$response = array('archive' => array('status' => 38,'message' =>'你已经取消关注改用户'));
	    return 'cancel';
	}

	function is_follow($mem_id,$from_id)
	{
		$map = 'SELECT count(*) as count 
				FROM follow
				WHERE mem_id="'.$mem_id.'" and from_id='.$from_id;
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		return $data = $result['count']?'yes':'no';
	}

	function follow_list($mem_id)
	{
		$map = 'SELECT * 
		FROM follow_list_from_to 
		WHERE from_id="'.$mem_id.'"';
		
		$query = $this->db->query($map);
		$result = $query->result_array();
		return $result;
	}

	function follow_list_other($mem_id)
	{
		$map = 'SELECT * 
		FROM follow_list_from_to_other 
		WHERE mem_id="'.$mem_id.'"';
		
		$query = $this->db->query($map);
		$result = $query->result_array();
		return $result;
	}

	function like($mem_id, $dis_id, $like, $from_id, &$response, $stas)
	{
		$result = array();
		$map = 'SELECT count(*) AS count
				FROM `like`
				WHERE mem_id="'.$mem_id.'" and dis_id='.$dis_id;
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		
		if ($result['count']) {

			$map = 'SELECT `'.$like.'` 
				FROM `like`
				WHERE mem_id="'.$mem_id.'" and dis_id='.$dis_id;
		
			$query = $this->db->query($map);
			$result = $query->row_array();

			if($result[$like])
			{
				$map = 'UPDATE `like` 
				SET `'.$like.'`=`'.$like.'`-1 
				WHERE dis_id="'.$dis_id.'" 
				AND mem_id='.$mem_id;
		
				$query = $this->db->query($map);
				$result = $this->db->affected_rows();

				$this->update_comment_like($dis_id, $like, -1);
				$stas->statistic($from_id,1,'cancel_'.$like);

				return $res = $result?$response = array('archive' => array('status' => 0,'message' =>'success')):$response = array('archive' => array('status' => 38,'message' =>'fail'));
			}
			else
			{
				$map = 'UPDATE `like` 
				SET `'.$like.'`=`'.$like.'`+1 
				WHERE dis_id="'.$dis_id.'" 
				AND mem_id='.$mem_id;
		
				$query = $this->db->query($map);
				$result = $this->db->affected_rows();
			}
			
		}
		else
		{
			$result = array();
			$map = 'INSERT `like`(mem_id,dis_id,`'.$like.'`) VALUES("'.$mem_id.'","'.$dis_id.'",1)';	
			$query = $this->db->query($map);
		    $result = $this->db->insert_id();   
		    
		}

		$this->update_comment_like($dis_id, $like, 1);
		$stas->statistic($from_id,1,$like);

		return $res = $result?$response = array('archive' => array('status' => 0,'message' =>'success')):$response = array('archive' => array('status' => 38,'message' =>'fail'));
		
	}

	function is_like($mem_id, $dis_id, $like)
	{
		$res = array();
		$map = 'SELECT `'.$like.'`, dis_id
				FROM `like`
				WHERE mem_id="'.$mem_id.'" and dis_id in ('.$dis_id.')';
		
		$query = $this->db->query($map);
		$result = $query->result_array();
		foreach ($result as $key => $value) {
			$res[] = $value[$like]?array('dis_id' => $value['dis_id'],$like => 'yes'):array('dis_id' => $value['dis_id'],$like => 'no');
		}
		return $res;
	}

	function cursor_user_info($mem_id)
	{
		$data = array();
		$map = 'SELECT id, nic_name, face, wealth 
				FROM member
				WHERE id="'.$mem_id.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();
		
		$result = array_merge($result,$this->follow_comment($mem_id));
		
		return $result;
	}

	function follow_comment($mem_id)
	{
		$map = 'SELECT count(*) AS comment_count 
				FROM comment
				WHERE from_id="'.$mem_id.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();

		$map = 'SELECT count(*) AS count 
			FROM follow
			WHERE mem_id='.$mem_id;
	
		$query = $this->db->query($map);
		$result['follow'] = $query->row_array();

		// $map = 'SELECT count(*) AS count 
		// 	FROM follow_comment
		// 	WHERE mem_id='.$mem_id;
	
		// $query = $this->db->query($map);
		// $result['follow'] = $query->row_array();

		$result['follow'] = $result['follow']['count'];
		return $result;
	}

	function sum_person($mem_id)
	{
		$map = 'SELECT wealth 
				FROM member
				WHERE id="'.$mem_id.'"';
		
		$query = $this->db->query($map);
		$result = $query->row_array();

		$map = 'SELECT count(*) AS comment_count 
				FROM comment
				WHERE from_id="'.$mem_id.'"';
		
		$query = $this->db->query($map);
		$result['comment_count'] = $query->row_array();

		// $map = 'SELECT count(*) AS follow_comment 
		// 	FROM follow_comment
		// 	WHERE mem_id='.$mem_id;
	
		// $query = $this->db->query($map);
		// $result['follow_comment'] = $query->row_array();

		$map = 'SELECT count(*) AS follow_mem 
			FROM follow
			WHERE from_id='.$mem_id;
	
		$query = $this->db->query($map);
		$result['follow_mem'] = $query->row_array();

		$result['comment_count'] = $result['comment_count']['comment_count'];
		// $result['follow_comment'] = $result['follow_comment']['follow_comment'];
		$result['follow_mem'] = $result['follow_mem']['follow_mem'];

		return $result;
	}
		
}










