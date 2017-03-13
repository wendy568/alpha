<?php  

class Activities extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function Activity_list()
	{
		$result = array();
		$map = 'SELECT *  
				FROM activity';	
		$query = $this->db->query($map);
        $result = $query->result_array();
        
        return $result;

	}

}