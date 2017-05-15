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

        if(isset($finency_proc) && $finency_proc) $where .= " AND order_symbol='{$finency_proc}'";
        if(isset($start_time) OR isset($end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (order_close_time>{$start_time} AND order_close_time<{$end_time})";
        }

    	$map = "SELECT * 
    			FROM mt4_export_datas
    			WHERE {$where}
                ORDER BY id DESC";

    	$result = $this->db->query($map)->result_array();

    	return $result;
    }

    function calendar($start_time = null, $end_time = null)
    {
        $where = "1=1";
        $now = time();

        if((isset($start_time) && $start_time) OR (isset($end_time) && $end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (time_en>{$start_time} AND time_en<{$end_time})";
        }

        $map = "SELECT time_en, time_cn, country AS `Currency`, event AS Event, Actual, consensus AS ForecASt, previous AS Previous, impact AS Importance, detail
                FROM calendar
                WHERE {$where}
                ORDER BY id DESC";

        $result = $this->db->query($map)->result_array();

        return $result;
    }

    function news($start_time = null, $end_time = null)
    {
        $where = "1=1";
        $now = time();

        if((isset($start_time) && $start_time) OR (isset($end_time) && $end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (time>{$start_time} AND time<{$end_time})";
        }

        $map = "SELECT title, `desc`, `time` 
                FROM news
                WHERE {$where}
                ORDER BY id DESC";

        $result = $this->db->query($map)->result_array();

        return $result;
    }

    function trading_count($account, $col = null, $param = null, $group = null)
    {
        $where = null;
        $group = ($group) ? "GROUP BY {$group}" : null;
        if ((isset($col) && $col) && (isset($param) && $param)) $where = " AND {$col} IN ({$param})";

        $map = "SELECT count(*) AS count  
                FROM mt4_export_datas
                WHERE account_number='{$account}' {$where} {$group}";
        print_r($map);

        $result = $this->db->query($map)->row_array();
        var_dump(($group) ? count($result['count']) : $result['count']);
        return $result['count'] = ($group) ? count($result['count']) : $result['count'];
    }

    function trading_count_gl($account, $col = null, $gl = '>')
    {
        $where = null;
        $group = ($group) ? "GROUP BY {$group}" : null;
        if (isset($col) && $col) $where = " AND {$col}{$gl}}0";
        $map = "SELECT count(*) AS count  
                FROM mt4_export_datas
                WHERE account_number='{$account}' {$where} 
                LIMIT 1";

        $result = $this->db->query($map)->row_array();
        return $result['count'];
    }

}