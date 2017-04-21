<?php  

class Activities extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function activity_list_for_admin($start, $limit)
    {
    	$start = $start?$start:0;
		$limit = $limit?$limit:10;
    	$map = "SELECT * 
    			FROM activity
    			LIMIT {$start},{$limit}";
    	
    	$result = $this->db->query($map)->result_array();
    	foreach ($result as $key => $value) {
			$result[$key]['image'] = json_decode($result[$key]['image']);
		}
    	return $result;
    }

	function Activity_list($start, $limit)
	{
		$start = $start?$start:0;
		$limit = $limit?$limit:10;
		$result = array();
		$map = "SELECT id, name, `describe`, start, `end`, location, image, status, focus, price
				FROM activity
				ORDER BY sort ASC
				LIMIT {$start},{$limit}";
		$query = $this->db->query($map);
        $result = $query->result_array();
        foreach ($result as $key => $value) {
			$result[$key]['image'] = json_decode($result[$key]['image']);
		}
        return $result;
	}

	function Activity_detail($id)
	{
		$map = 'SELECT * 
				FROM activity
				WHERE id='.$id;
		
		$result = $this->db->query($map)->row_array();
		$result['image'] = json_decode($result['image']);
		return $result;
	}
	function push_Orchange_item_status($id, $status, $item)
	{
		$map = "UPDATE activity 
				SET {$item}='".$status."' 
				WHERE id='".$id."'";
		
		$this->db->query($map);
		$result = $this->db->affected_rows();
	
		return $result;
	}

	function activity_order_list($mem_id, $start, $limit)
	{
		$start = $start?$start:0;
		$limit = $limit?$limit:10;
		$map = "SELECT eo.id AS order_id, eo.order_no, eo.event_id AS activity_id, eo.status AS order_status, eo.price AS order_total_price, eo.mem_id, eo.create_time, a.name, a.`describe`, a.image, eo.num, a.price 
				FROM event_order eo 
				LEFT JOIN activity a
				ON a.id=eo.event_id 
				WHERE eo.mem_id='".$mem_id."'
				ORDER BY eo.id DESC 
				LIMIT {$start},{$limit}";
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) {
			$result[$key]['image'] = json_decode($result[$key]['image']);
		}
		return $result;
	}

	function activity_order_detail($order_no)
	{
		$map = 'SELECT  a.name, a.start, a.end, a.location, eo.create_time, eo.order_no, eo.payment, eo.price
				FROM event_order eo 
				LEFT JOIN activity a 
				ON a.id=eo.event_id 
				WHERE eo.order_no="'.$order_no.'"';
		
		$result = $this->db->query($map)->row_array();
		return $result;
	}

}