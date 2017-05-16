<?php  

class ClassesM extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function allProcess()
    {
    	$map = 'SELECT homework 
    			FROM classes';
    	
    	$result = $this->db->query($map)->result_array();
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

	function showStageDetail($stageId, $uid)
	{
		$result = array();

		$map = "SELECT *  
				FROM classes
				WHERE id = {$stageId}";	

		$query = $this->db->query($map);
        $result['mission'] = $query->row_array();

        $map = 'SELECT * 
    			FROM homework
    			WHERE uid="'.$uid.'"';
    	
    	$result['homework'] = $this->db->query($map)->row_array();
        
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

}