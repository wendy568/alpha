<?php  

class TradingAnalysis extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function export_mt4_datas($finency_proc)
    {
    	$map = "SELECT * 
    			FROM mt4_export_datas
    			WHERE 1=1";
    	
    	$result = $this->db->query($map)->result_array();
    	return $result;
    }

}