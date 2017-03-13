<?php  

class Orders extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

    function create_order_for_zone_plus($mem_id, $zone_plus_id, $price, $table, $payment, $num, $info)
    {
		$result = array();
		$info_col = (isset($info) && $info) ? ",info" : null;
		$info_value = (isset($info) && $info) ? ",'{$info}'" : null;
		$status = 0;
		$order_no = 'AZP'.time().mt_rand(100,999).$mem_id;
		$create_time = date('Y-m-d H:i:s', time());
		$payment = isset($payment) ? $payment : 0;
		$map = "INSERT ${table}(mem_id,zone_plus_id,order_no,price,status,create_time,payment,num{$info_col}) VALUES('".$mem_id."','".$zone_plus_id."','".$order_no."','".$price."','".$status."','".$create_time."','".$payment."','".$num."'{$info_value})";
		$this->db->query($map);
	    $result['event_order_id'] = $this->db->insert_id();   
	    $result['event_order_no'] = $order_no;
	    return $result;
	}

    function create_order_for_trading_floor($mem_id, $tr_fl_id, $price, $table, $payment, $num, $info)
    {
		$result = array();
		$info_col = (isset($info) && $info) ? ",info" : null;
		$info_value = (isset($info) && $info) ? ",'{$info}'" : null;
		$status = 0;
		$order_no = 'AZ'.time().mt_rand(100,999).$mem_id;
		$create_time = date('Y-m-d H:i:s', time());
		$payment = isset($payment) ? $payment : 0;
		$map = "INSERT ${table}(mem_id,tr_fl_id,order_no,price,status,create_time,payment,num{$info_col}) VALUES('".$mem_id."','".$tr_fl_id."','".$order_no."','".$price."','".$status."','".$create_time."','".$payment."','".$num."'{$info_value})";
		$this->db->query($map);
	    $result['event_order_id'] = $this->db->insert_id();   
	    $result['event_order_no'] = $order_no;
	    return $result;
	}

	function create_order($mem_id, $event_id, $price, $table, $payment, $num, $info)
	{
		$result = array();
		$info_col = (isset($info) && $info) ? ",info" : null;
		$info_value = (isset($info) && $info) ? ",'{$info}'" : null;
		$status = 0;
		$order_no = 'AE'.time().mt_rand(100,999).$mem_id;
		$create_time = date('Y-m-d H:i:s', time());
		$payment = isset($payment) ? $payment : 0;
		$map = "INSERT ${table}(mem_id,event_id,order_no,price,status,create_time,payment,num{$info_col}) VALUES('".$mem_id."','".$event_id."','".$order_no."','".$price."','".$status."','".$create_time."','".$payment."','".$num."'{$info_value})";
		$this->db->query($map);
	    $result['event_order_id'] = $this->db->insert_id();   
	    $result['event_order_no'] = $order_no;
	    return $result;
	}

	function pay_order($order_no, $status, $table)
	{
		$map = "UPDATE ${table} 
				SET status='".$status."'
				WHERE order_no='".$order_no."'";
		
		$this->db->query($map);
		$result = $this->db->affected_rows();
		
		return $result;
	}		

	function is_payment($order_no, $table, &$response)
	{
		$map = "SELECT status 
				FROM ${table}
				WHERE order_no='".$order_no."'";
		
		$result = $this->db->query($map)->row_array();

		if ($result['status'] == 0 or $result['status'] == 2) {
			$response['status'] = 113;
			$response['message'] = 'payment Unfinished';
		} else {
			$response['status']= 0;
			$response['message'] = 'payment success';
		}
		return $response;
	}

	function select_payment($payment = null)
	{
		$where  = ' WHERE 1=1';
		$where .= (isset($payment) && $payment) ? ' AND status='.$payment : null; 
		$map = 'SELECT name, status
				FROM payment'.$where;
		
		$result = $this->db->query($map)->result_array();
		return $result;
	}
	
}