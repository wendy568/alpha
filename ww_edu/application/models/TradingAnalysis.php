<?php  

class TradingAnalysis extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function export_mt4_datas($finency_proc)
    {
        if(isset($finency_proc)) $where .= " AND order_symbol={$finency_proc}";
    	$map = "SELECT * 
    			FROM mt4_export_datas
    			WHERE 1=1 {$where}";
    	
    	$result = $this->db->query($map)->result_array();
    	return $result;
    }

}