<?php  

class TradingAnalysis extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function export_mt4_datas($account = null, $finency_proc = null, $start_time = null, $end_time = null)
    {
        $now = time();
        if(isset($finency_proc)) $where .= " AND order_symbol='{$finency_proc}'";
        if(isset($start_time) OR isset($end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (order_close_time>{$start_time} AND order_close_time<{$end_time})";
        }
    	$map = "SELECT * 
    			FROM mt4_export_datas
    			WHERE account='{$account}' 
                AND {$where}";

    	$result = $this->db->query($map)->result_array();
    	return $result;
    }

}