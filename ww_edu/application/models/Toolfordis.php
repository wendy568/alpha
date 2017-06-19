<?php  

class Toolfordis extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function ranking_list()
	{
		$result = array();
		$map = 'SELECT nic_name, face, wealth  
				FROM member
				GROUP BY wealth 
				ORDER BY wealth DESC 
				LIMIT 10';	
		$query = $this->db->query($map);
        $result = $query->result_array();
        shuffle($result);
        return $result;

	}

	function test()
	{
		$map = 'SELECT * 
				FROM calendar
				LIMIT 100';
		
		$result = $this->db->query($map)->result_array();
		return $result;
	}

}