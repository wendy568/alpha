<?php  

class Remarks extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function list($uid, $start = null, $limit = null)
	{
		$a = 0;
		var_dump(isset($a));
		$start = (isset($start) && $start) ? $start : 0;
		$limit = (isset($limit) && $limit) ? $limit : 10; 
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