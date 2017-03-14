<?php  

class TradingAnalysis extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function export_mt4_datas($account = null, $finency_proc = null)
    {
        $where = "1=1";
        if(isset($finency_proc)) $where .= " AND order_symbol={$finency_proc}";
    	$map = "SELECT * 
    			FROM mt4_export_datas
    			WHERE {$where}";
    	
    	$result = $this->db->query($map)->result_array();
    	return $result;
    }

}