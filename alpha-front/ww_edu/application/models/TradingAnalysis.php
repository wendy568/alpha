<?php  

class TradingAnalysis extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function export_mt4_datas($account = null, $finency_proc = null, $start_time = null, $end_time = null, $some_time = null)
    {
        $where = "account_number='{$account}'";
        $now = time();

        if(isset($finency_proc) && $finency_proc) $where .= " AND order_symbol='{$finency_proc}'";
        if(isset($start_time) OR isset($end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (order_close_time>{$start_time} AND order_close_time<{$end_time})";
        }
        if(isset($some_time) && $some_time) $where .= " AND order_close_time>{$some_time}";

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
            $where .= " AND (time_cn>{$start_time} AND time_cn<{$end_time})";
        }

        $map = "SELECT time_en, time_cn, country AS `Currency`, event AS Event, Actual, consensus AS ForecASt, previous AS Previous, impact AS Importance, detail
                FROM calendar
                WHERE {$where}
                ORDER BY id DESC";

        $result = $this->db->query($map)->result_array();

        return $result;
    }

    function calendarForApi($start_time = null, $end_time = null)
    {
        $where = "1=1";
        $now = time();

        if((isset($start_time) && $start_time) OR (isset($end_time) && $end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (time_cn>{$start_time} AND time_cn<{$end_time})";
        }

        $map = "SELECT *
                FROM calendar
                WHERE {$where}
                ORDER BY id DESC
                LIMIT 500";

        $result = $this->db->query($map)->result_array();

        return $result;
    }

    function newsForApi($start_time = null, $end_time = null)
    {
        $where = "1=1";
        $now = time();

        if((isset($start_time) && $start_time) OR (isset($end_time) && $end_time)) {
            $start_time = ($start_time) ? $start_time : 0;
            $end_time = ($end_time) ? $end_time : $now;
            $where .= " AND (time>{$start_time} AND time<{$end_time})";
        }

        $map = "SELECT * 
                FROM news
                WHERE {$where}
                ORDER BY id DESC
                LIMIT 500";

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

    function trading_count($account, $time, $col = null, $param = null)
    {
        $where = null;
        if ((isset($col) && $col) && (isset($param) && $param)) $where = " AND {$col} IN ({$param})";

        $map = "SELECT count(*) AS count  
                FROM mt4_export_datas
                WHERE account_number='{$account}' AND order_close_time>={$time} {$where}";

        $result = $this->db->query($map)->row_array();

        return $result['count'];
    }

    function tradingCountGroup($account, $group, $time)
    {
        $map = "SELECT *  
                FROM mt4_export_datas
                WHERE account_number='{$account}' AND order_close_time>={$time} GROUP BY {$group}";

        $result = $this->db->query($map)->result_array();

        return count($result);
    }

    function tradingCountGL($account, $col = [], $time)
    {
        $where = null;
        $count = 0;

        if (!empty($col)) {
            foreach ($col as $key) {
                $where = " AND {$key}>0";
                $map = "SELECT *  
                        FROM mt4_export_datas
                        WHERE account_number='{$account}' AND order_close_time>={$time} {$where} 
                        LIMIT 1";

                $result = $this->db->query($map)->result_array();

                $count += count($result);
            }
            
        }
        
        return $count;
    }

    function tradingCountIn($account, $col, $prod = [], $time)
    {
        $where = null;
        $count = 0;

        if (!empty($prod)) {
            foreach ($prod as $value) {
                $symbols = implode('\',\'', $value);
                $where = " AND {$col} IN ('{$symbols}')";
                $map = "SELECT *  
                        FROM mt4_export_datas
                        WHERE account_number='{$account}' AND order_close_time>={$time} {$where} 
                        LIMIT 1";

                $result = $this->db->query($map)->result_array();

                $count += count($result);
            }
            
        }
        
        return $count;
    }

}