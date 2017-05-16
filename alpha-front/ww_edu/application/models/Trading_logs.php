<?php  

class Trading_logs extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function tradingLogList($uid = null)
	{
		$where = "uid='{$uid}'";
		$result = array();
		$map = "SELECT *  
				FROM trading_log 
				WHERE $where 
				ORDER BY id DESC";	

		$query = $this->db->query($map);
        $result = $query->result_array();
        
        return $result;
	}

	function logs_count($uid, $time, $col = null, $param = null)
	{
	    $where = null;
	    if ((isset($col) && $col) && (isset($param) && $param)) $where = " AND {$col} IN ({$param})";

	    $map = "SELECT count(*) AS count  
	            FROM trading_log
	            WHERE uid='{$uid}' AND c_time>{$time} {$where}";

	    $result = $this->db->query($map)->row_array();

	    return $result['count'];
	}


}