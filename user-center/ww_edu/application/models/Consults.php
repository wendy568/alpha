<?php  

class Consults extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function list_forConsult($start, $limit, $table)
    {

    	$start = $start?$start:0;
		$limit = $limit?$limit:10;

    	$map = "SELECT * 
    			FROM {$table}
    			LIMIT {$start},{$limit}";
    	
    	$result = $this->db->query($map)->result_array();

    	foreach ($result as $key => $value) 
        {
        	if (!empty($value['image'])) {
        		$result[$key]['image'] = json_decode($result[$key]['image']);
        	}
        	if (!empty($value['content'])) {
        		$result[$key]['content'] = mb_substr(strip_tags($value['content']), 0, 250,'utf8');
        	}
        }
    	return $result;

    }

    function show_navigation()
    {
    	$map = 'SELECT * 
    			FROM navigation';
    	
    	$result = $this->db->query($map)->result_array();
    	return $result;
    }

    function list_forNews($start, $limit)
    {
    	$start = $start?$start:0;
		$limit = $limit?$limit:10;

    	$map = "SELECT id, title, content, create_time 
    			FROM news_text
    			LIMIT {$start},{$limit}";
    	
    	$result = $this->db->query($map)->result_array();
    	foreach ($result as $key => $value) {
    		$result[$key]['content'] = mb_substr(strip_tags($value['content']), 0, 250,'utf8');
    	}
    	return $result;
    }

    function list_forActivity($start, $limit, $navi_id)
    {
    	$start = $start?$start:0;
		$limit = $limit?$limit:10;

    	$map = "SELECT * 
    			FROM activity 
    			WHERE navi_id={$navi_id} 
    			LIMIT {$start},{$limit}";
    	
    	$result = $this->db->query($map)->result_array();
    	foreach ($result as $key => $value) 
        {
        	if (!empty($value['image'])) {
        		$result[$key]['image'] = json_decode($result[$key]['image']);
        	}
        	if (!empty($value['describe'])) {
        		$result[$key]['describe'] = mb_substr(strip_tags($value['describe']), 0, 250,'utf8');
        	}
        }
    	return $result;
    }

    function show_activity_onTrader($start, $limit)
    {

    	$start = $start?$start:0;
		$limit = $limit?$limit:10;

    	$map = "SELECT * 
    			FROM activity
    			WHERE recommend=1 
    			LIMIT {$start},{$limit}";
    	
    	$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) 
	    {
	    	if (!empty($value['image'])) {
	    		$result[$key]['image'] = json_decode($result[$key]['image']);
	    	}
	    	if (!empty($value['describe'])) {
	    		$result[$key]['describe'] = mb_substr(strip_tags($value['describe']), 0, 250,'utf8');
	    	}
	    }
    	return $result;
    }

    function detail_forActivity($id)
    {
    	$map = 'SELECT * 
    			FROM activity
    			WHERE id="'.$id.'"';
    	
    	$result = $this->db->query($map)->row_array();
    	if (!empty($result['image'])) {
    		$result['image'] = json_decode($result['image']);
    	}
    	return $result;
    }

    function detail_forNews($id)
    {
    	$map = 'SELECT title, content, create_time 
    			FROM news
    			WHERE id="'.$id.'"';
    	
    	$result = $this->db->query($map)->row_array();
    	return $result;
    }

    function detail_forConsult($id, $table)
    {
    	$map = "SELECT * 
    			FROM {$table}
    			WHERE id=".$id;
    	
    	$result = $this->db->query($map)->row_array();

    	if (!empty($result['image'])) {
    		$result['image'] = json_decode($result['image']);
    	}

    	return $result;
    }

	function add_consult($cols, &$response)
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

	function update_consult($cols, &$response)
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

	function show_consults_onZone($time)
	{
		$map = 'SELECT n.*, m.nic_name  
				FROM news n 
				LEFT JOIN member m 
				ON m.id=n.from_id 
				WHERE n.recommend=1 AND n.type=1';
		
		$result['facebook'] = $this->db->query($map)->row_array();
		// if(!empty($result['facebook']['image']))$result['facebook']['image'] = json_decode($result['facebook']['image']);
		$map = 'SELECT n.*, m.nic_name  
						FROM news n 
						LEFT JOIN member m 
						ON m.id=n.from_id 
						WHERE n.recommend=1 AND n.type=2';
		
		$result['twitter'] = $this->db->query($map)->row_array();
		// if(!empty($result['twitter']['image'])) $result['twitter']['image'] = json_decode($result['twitter']['image']);
		$map = 'SELECT n.*, m.nic_name  
						FROM news n 
						LEFT JOIN member m 
						ON m.id=n.from_id 
						WHERE n.recommend=1 AND n.type=0';
		
		$result['financial'] = $this->db->query($map)->row_array();
		// if(!empty($result['financial']['image'])) $result['financial']['image'] = json_decode($result['financial']['image']);
		foreach ($result as $key => $value) 
        {
        	if (!empty($value)) {
        		$time->sec = date('s', strtotime($result[$key]['create_time']));
        		$time->day = date('z', strtotime($result[$key]['create_time']));
        		$time->mon = date('m', strtotime($result[$key]['create_time']));
        		$time->min = date('i', strtotime($result[$key]['create_time']));
        		$time->hour = date('H', strtotime($result[$key]['create_time']));
        		$time->year = date('Y', strtotime($result[$key]['create_time']));
        		$result[$key]['ago_time'] = $time->filter_time();
        		$result[$key]['image'] = json_decode($result[$key]['image']);
        		$result[$key]['content'] = mb_substr(strip_tags($value['content']), 0, 250,'utf8');
        	}  
        }
		return $result;
	}

	function show_banner($page)
	{
		$map = 'SELECT * 
				FROM banner
				WHERE page="'.$page.'"';
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) {
			$result[$key]['image'] = json_decode($result[$key]['image']);
		}
		return $result;
	}

	function show_ad($page,$position)
	{
		$map = 'SELECT * 
				FROM ad
				WHERE page="'.$page.'" AND position="'.$position.'"';
		
		$result = $this->db->query($map)->row_array();
		$result['image'] = json_decode($result['image']);
		return $result;
	}

	function show_formForTrader($from_id, $navi_id)
	{
		$where = ($navi_id) ? ' AND a.navi_id='.$navi_id : null;
		$map = 'SELECT a.id AS activity_id, f.id AS form_id, a.name, f.status, f.create_time  
				FROM activity a 
				LEFT JOIN form f 
				ON f.activity_id=a.id 
				WHERE f.from_id="'.$from_id.'"'.$where; 
				// AND a.navi_id="'.$navi_id.'"';
		
		$result = $this->db->query($map)->result_array();
		return $result;
	}

	function delete_consult($id, $table)
	{
		$map = "DELETE FROM {$table} 
				WHERE id=".$id;
		
		$this->db->query($map);
	}

}