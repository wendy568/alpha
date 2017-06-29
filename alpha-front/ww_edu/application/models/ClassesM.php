<?php  

class ClassesM extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function allProcess()
    {
    	$map = 'SELECT id, homework 
    			FROM classes';
    	
    	$result = $this->db->query($map)->result_array();
    	return $result;
    }

    function show_history($uid)
    {
    	$map = 'SELECT homework 
    			FROM homework_history
    			WHERE uid="'.$uid.'"';
    	
    	$result = $this->db->query($map)->row_array();

    	return $result;
    }

    function get_mission($id)
    {
    	$map = 'SELECT homework 
    			FROM classes
    			WHERE id="'.$id.'"';
    	
    	$result = $this->db->query($map)->row_array();

    	return $result;
    }

    function current_stage($uid)
    {
    	$result = [];

    	$map = 'SELECT hw_id, homework, u_time 
    			FROM homework
    			WHERE uid="'.$uid.'"';
    	
    	$result['personal'] = $this->db->query($map)->row_array();

    	$map = "SELECT title, `describe`, homework  
				FROM classes
				WHERE id = {$result['personal']['hw_id']}";	

		$query = $this->db->query($map);
		
        $result['mission'] = $query->row_array();

    	return $result;
    }

	function showStageDetail($stageId)
	{
		$result = array();

		$map = "SELECT *  
				FROM classes
				WHERE id = {$stageId}";	

		$query = $this->db->query($map);
        $result = $query->row_array();
        
        return $result;

	}

	function showData($ids, $table, $cols)
	{
		$cols = ($cols) ? $cols : '*';
		$map = 'SELECT '.$cols.' 
				FROM '.$table.'
				WHERE id IN('.$ids.')';
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) 
        {
        	if (!empty($result[$key]['image'])) {
        		$result[$key]['image'] = json_decode($result[$key]['image']);
        	}
        }
		return $result;
	}

	function saveRecord($uid, $homework)
	{
		$map = 'UPDATE homework 
				SET homework="'.$homework.'"
				WHERE uid="'.$uid.'"';
		
		$this->db->query($map);
		$result = $this->db->affected_rows();
	
		return $result;
	}

	function article_detail($id)
	{
		$map = 'SELECT * 
				FROM article
				WHERE id="'.$id.'"';
		
		$result = $this->db->query($map)->row_array();
		return $result;
	}

}