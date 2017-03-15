<?php
use Alipay\AlipayNotify;

class Order extends MY_Controller
{
	public function get_bytoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken($token);
		return $data;
	}

	public function select_payment()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$payment = $this->input->get_post('payment', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('orders');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->orders->select_payment($payment);
	
		encode_json($response,$data);
	}

	public function create_order()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$table = $this->input->get_post('table', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$from_id = $this->get_bytoken($token);
		$payment = $this->input->get_post('payment', TRUE);
		$price = $this->input->get_post('price', TRUE);
		$event_id = $this->input->get_post('event_id', TRUE);
		$num = $this->input->get_post('num', TRUE);
		$info = $this->input->get_post('info', TRUE);

		if(!empty($info)) $info = addslashes($info);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('orders');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		if($table == 'tr_fl_order') {
			$data['data'] = $this->orders->create_order_for_trading_floor($from_id, $event_id, $price, $table, $payment, $num, $info);
		} elseif ($table == 'event_order') {
			$data['data'] = $this->orders->create_order($from_id, $event_id, $price, $table, $payment, $num, $info);
		} elseif ($table == 'zone_plus_order') {
			$data['data'] = $this->orders->create_order_for_zone_plus($from_id, $event_id, $price, $table, $payment, $num, $info);
		}
		
	
		encode_json($response,$data);
	}

	public function handler_order_notify()
	{

		header( 'Access-Control-Allow-Origin:*' );

		$alipay_config = array();

		$this->load->helper('constants');
		$const = constants::build();

		$alipay_config = $const->alphatrader['alipay'];
		$alipay_config['sign_type'] = strtoupper('MD5');
		$alipay_config['input_charset'] = strtolower('utf-8');
		$alipay_config['cacert'] = getcwd().'/cacert.pem';

		$this->load->database();
		$this->load->model('orders');
		$data = array();

		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {
			$this->pay_order($this->input->get_post('trade_status', TRUE), 1, $this->input->get_post('out_trade_no', TRUE));
			echo 'success';
		} else {
			echo "fail";
		}
	}

	public function handler_order()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$alipay_config = array();

		$this->load->helper('constants');
		$const = constants::build();

		$alipay_config = $const->alphatrader['alipay'];
		$alipay_config['sign_type'] = strtoupper('MD5');
		$alipay_config['input_charset'] = strtolower('utf-8');
		$alipay_config['cacert'] = getcwd().'/cacert.pem';

		$this->load->database();
		$this->load->model('orders');
		$data = array();

		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		// ob_start();
		if($verify_result) {
			$url = $this->pay_order($this->input->get_post('trade_status', TRUE), 1, $this->input->get_post('out_trade_no', TRUE));
			// echo 'success';
		} else {
			// echo "fail";
		}
		header("Location: {$url}");
		// ob_end_flush();
	}

	public function pay_order($trade_status, $status, $out_trade_no)
	{		
		header( 'Access-Control-Allow-Origin:*' );

		preg_match_all( '/[a-zA-Z]+/', $out_trade_no ,$array);
		if($array[0][0] == 'AE') $table = 'event_order';
		if($array[0][0] == 'AZ') $table = 'tr_fl_order';
		if($array[0][0] == 'AZP') $table = 'zone_plus_order';
		
		$this->load->database();
		$this->load->model('orders');
		$data = array();
		if($trade_status == 'TRADE_FINISHED') {
			$this->orders->pay_order($out_trade_no, $status, $table);
	    } else if ($trade_status == 'TRADE_SUCCESS') {
	    	$this->orders->pay_order($out_trade_no, $status, $table);
	    } 
	    return $this->where_shall_i_redirect_to($table);
	}

	public function where_shall_i_redirect_to($go)
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		return "http://120.25.211.159/#/tv_list?go={$go}";
	}

	public function is_payment()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$out_trade_no = $this->input->get_post('out_trade_no', TRUE);	
		$table = $this->input->get_post('table', TRUE);	

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('orders');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->orders->is_payment($out_trade_no, $table, $response['archive']);
	
		encode_json($response,$data);
	}
}