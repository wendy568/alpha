<?php  

class ClassesM extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function current_stage($uid)
    {
    	var_dump($uid);
    	$map = 'SELECT homework 
    			FROM homework
    			WHERE uid="'.$uid.'"';
    	
    	$result = $this->db->query($map)->row_array();
    	print_r($result);
    	return $result['homework'];
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