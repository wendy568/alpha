<?php  

class ZoneAndPluses extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function zonePlus_list()
    {
    	$map = 'SELECT * 
    			FROM zone_plus';
    	
    	$result = $this->db->query($map)->result_array();
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

	function zone_plus_order_list($mem_id, $start, $limit)
	{
		$map = "SELECT  zpo.id AS order_id, tf.id AS zone_plus_id, zpo.order_no, zpo.mem_id, tf.location, tf.`describe`, zpo.num, zpo.price AS order_total_price, zpo.status AS order_status, tf.image, zpo.create_time 
				FROM zone_plus_order zpo
				LEFT JOIN trading_floor tf 
				ON tf.id=zpo.zone_plus_id
				WHERE zpo.mem_id=".$mem_id." 
				ORDER BY zpo.id DESC 
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

	function zone_plus_order_detail($order_no)
	{
		$map = 'SELECT zp.id AS zp_id, zp.name, zp.price, zpo.info, zpo.create_time, zpo.order_no, zpo.payment 
				FROM zone_plus_order zpo
				LEFT JOIN zone_plus zp
				ON zp.id=zpo.zone_plus_id 
				WHERE order_no="'.$order_no.'"';
		
		$result = $this->db->query($map)->row_array();
		$result['info'] = json_decode($result['info']);
		
		return $result;
	}
}