<?php  

class Trading_logs extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function show_trading_logs()
	{
		$result = array();
		$map = 'SELECT *  
				FROM trading_log';	
		$query = $this->db->query($map);
        $result = $query->result_array();
        
        return $result;

	}

	function test($uu, $sign)
	{
		$result = array();
		$map = 'INSERT test2(uu,sign) VALUES("'.$uu.'","'.$sign.'")';	
		$this->db->query($map);
	    $result = $this->db->insert_id();   
	    
	    return $result;
	
	}

}