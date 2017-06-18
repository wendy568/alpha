<?php  

class Remarks extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function list($uid, $start = null, $limit = null)
	{
		$start = (isset($start) && $start) ? $start : 0;
		$limit = (isset($limit) && $limit) ? $limit : 10; 
		$result = array();
		$map = "SELECT id, admin, content, uid, u_time
				FROM remark
				WHERE uid={$uid}
				ORDER BY u_time DESC
				LIMIT {$start},{$limit}";

		$query = $this->db->query($map);
        $result = $query->result_array();
        
        return $result;

	}

}