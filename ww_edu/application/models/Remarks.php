<?php  

class Remarks extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function list($uid, $start = null, $limit = null)
	{
		$start = (isset($start) OR $start) ? $start : 0;
		$limit = (isset($limit) OR $limit) ? $limit : 10; 
		$result = array();
		$map = "SELECT *  
				FROM remark
				WHERE uid={$uid}
				LIMIT {$start},{$limit}";
		print_r($map);
		$query = $this->db->query($map);
        $result = $query->result_array();
        
        return $result;

	}

}