<?php  

class TradingAnalysis extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function export_mt4_datas($account = null, $finency_proc = null, $start_time = null, $end_time = null)
    {
        $where = "account_number='{$account}'";
        $now = time();
        if(isset($finency_proc)) $where .= " AND order_symbol='{$finency_proc}'";
        if(isset($start_time) OR isset($end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (order_close_time>{$start_time} AND order_close_time<{$end_time})";
        }
    	$map = "SELECT * 
    			FROM mt4_export_datas
    			WHERE {$where}";

    	$result = $this->db->query($map)->result_array();
        print_r($result);
    	return $result;
    }

    function calender($start_time = null, $end_time = null)
    {
        $where = "1=1";
        $now = time();
        if(isset($start_time) OR isset($end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (time_en>{$start_time} AND time_en<{$end_time})";
        }
        $map = "SELECT * 
                FROM calender
                WHERE {$where}";

        $result = $this->db->query($map)->result_array();
        print_r($result);
        return $result;
    }

}