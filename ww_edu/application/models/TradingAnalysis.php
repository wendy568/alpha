<?php  

class TradingAnalysis extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function export_mt4_datas()
    {
    	$map = "SELECT * 
    			FROM mt4_export_datas
    			WHERE order_symbol=AUDUSD";
    	
    	$result = $this->db->query($map)->result_array();
    	return $result;
    }

}