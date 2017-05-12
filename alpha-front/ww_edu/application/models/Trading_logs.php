<?php  

class Trading_logs extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function tradingLogList($uid = null)
	{
		$where = "account_number='{$uid}'";
		$result = array();
		$map = "SELECT *  
				FROM trading_log 
				WHERE $where";	
		$query = $this->db->query($map);
        $result = $query->result_array();
        
        return $result;

	}

}