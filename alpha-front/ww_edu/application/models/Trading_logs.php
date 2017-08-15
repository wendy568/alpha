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

	function logsListForAdmin($uid, $start = null, $limit = null)
	{
		$start = (isset($start) && $start) ? $start : 0;
		$limit = (isset($limit) && $limit) ? $limit : 10; 
		$result = [];

		$map = "SELECT COUNT(*) AS count
				FROM trading_log
				WHERE uid={$uid}";

		$query = $this->db->query($map);
		$result['count'] = $query->row_array()['count'];

		$map = "SELECT id, title, content, color, uid, u_time
				FROM trading_log
				WHERE uid={$uid}
				ORDER BY u_time DESC
				LIMIT {$start},{$limit}";

		$query = $this->db->query($map);
        $result['list'] = $query->result_array();
        
        return $result;

	}

	function logs_count($uid, $time, $col = null, $param = null)
	{
	    $where = null;
	    if ((isset($col) && $col) && (isset($param) && $param)) $where = " AND {$col} IN ({$param})";

	    $map = "SELECT count(*) AS count  
	            FROM trading_log
	            WHERE uid='{$uid}' AND c_time>={$time} {$where}";

	    $result = $this->db->query($map)->row_array();

	    return $result['count'];
	}


}