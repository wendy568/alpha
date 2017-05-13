<?php  

class ClassesM extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function current_stage($uid)
    {
    	$map = 'SELECT hw_id, homework 
    			FROM homework
    			WHERE uid="'.$uid.'"';
    	
    	$result['personal'] = $this->db->query($map)->row_array();

    	$map = "SELECT *  
				FROM classes
				WHERE id = {$result['homework']['hw_id']}";	

		$query = $this->db->query($map);
        $result['mission'] = $query->row_array();

    	return $result;
    }

    function All_stages()
    {
    	$map = 'SELECT * 
    			FROM classes';
    	
    	$result = $this->db->query($map)->result_array();
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

}