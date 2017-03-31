<?php  

class ZoneAndPluses extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function zonePlus_list()
    {
    	$map = 'SELECT id, name, location, status
    			FROM alpha_trader';
    	
    	$result = $this->db->query($map)->result_array();
    	foreach ($result as $key => $value) {
			$result[$key]['status'] = json_decode($result[$key]['status']);
		}
    	return $result;
    }

    function zone_list($start, $limit)
    {
		$start = $start?$start:0;
		$limit = $limit?$limit:10;
		$result = array();
		$map = "SELECT * 
				FROM trading_floor
				LIMIT {$start},{$limit}";
		$query = $this->db->query($map);
        $result = $query->result_array();
        foreach ($result as $key => $value) {
			$result[$key]['image'] = json_decode($result[$key]['image']);
		}
        return $result;
	}

	function zone_order_list($mem_id, $start, $limit)
	{
		$map = "SELECT  tfo.id AS order_id, tf.id AS zone_id, tfo.order_no, tfo.mem_id, tf.location, tf.`describe`, tfo.num, tfo.price AS order_total_price, tfo.status AS order_status, tf.image, tfo.create_time 
				FROM tr_fl_order tfo
				LEFT JOIN trading_floor tf 
				ON tf.id=tfo.tr_fl_id
				WHERE tfo.mem_id=".$mem_id." 
				ORDER BY tfo.id DESC 
				LIMIT {$start},{$limit}";
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) {
			$result[$key]['image'] = json_decode($result[$key]['image']);
		}
		return $result;
	}

	function alpha_trader_order_list($mem_id, $start, $limit)
	{
		$map = "SELECT  ato.id AS order_id, tf.id AS al_tr_id, ato.order_no, ato.mem_id, tf.location, tf.`describe`, ato.num, ato.price AS order_total_price, ato.status AS order_status, tf.image, ato.create_time 
				FROM alpha_trader_order ato
				LEFT JOIN trading_floor tf 
				ON tf.id=ato.al_tr_id
				WHERE ato.mem_id=".$mem_id." 
				ORDER BY ato.id DESC 
				LIMIT {$start},{$limit}";
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) {
			$result[$key]['image'] = json_decode($result[$key]['image']);
		}
		return $result;
	}

	function zone_order_detail($order_no)
	{
		$map = 'SELECT tf.id AS tf_id, tf.address, tfo.info, tfo.create_time, tfo.order_no, tfo.payment, tfo.price  
				FROM tr_fl_order tfo
				LEFT JOIN trading_floor tf
				ON tf.id=tfo.tr_fl_id 
				WHERE order_no="'.$order_no.'"';
		
		$result = $this->db->query($map)->row_array();
		$result['info'] = json_decode($result['info']);
		
		return $result;
	}

	function alpha_trader_order_detail($order_no)
	{
		$map = 'SELECT at.id AS at_id, at.name, at.price, ato.info, ato.create_time, ato.order_no, ato.payment 
				FROM alpha_trader_order ato
				LEFT JOIN alpha_trader at
				ON at.id=ato.al_tr_id 
				WHERE order_no="'.$order_no.'"';
		
		$result = $this->db->query($map)->row_array();
		$result['info'] = json_decode($result['info']);
		
		return $result;
	}
}