<?php

use Blablacar\Memcached\Client;
class Activity extends MY_Controller
{
	public function activity_list_for_admin()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$this->get_byadmintoken($token);
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Activities');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Activities->activity_list_for_admin($start, $limit);
	
		encode_json($response,$data);
	}

	public function Activity_list()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('month_zone');
		$this->load->model('Activities');

		// $client = new Client();
		// $client->addServer('localhost', 11211);
		// $paras = 'activity/activity_list';
		// if($cached = $client->get($paras)) {
		// 	exit($cached);
		// }

		$response = array('archive' => array('status' => 0,'message' =>''));
		$params = time_splice($this->Activities->Activity_list($start, $limit), 'start');
		$data['data'] = isset($params) ? sort_recursive($params) : $params;
		// encode_json($response, $data, $client, $paras);
		encode_json($response, $data);
	}

	public function Activity_detail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$id = $this->input->get_post('id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Activities');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Activities->Activity_detail($id);
	
		encode_json($response,$data);
	}

	public function push_Orchange_item_status()
	{
		header( 'Access-Control-Allow-Origin:*' );

		if(verb_method_enable('put')) {
			$this->_exit(400, 0, 'Not Acceptable');
		}

		$this->get_byadmintoken($this->input->input_stream('token', TRUE));
		$status = $this->input->input_stream('status', TRUE);
		$id = $this->input->input_stream('id', TRUE);
		$item = $this->input->input_stream('item', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Activities');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['bool'] = $this->Activities->push_Orchange_item_status($id, $status, $item);
		$code = ($data['data']['bool']) ? 200 : 204;

		encode_json($response, $data, $code);
	}

	public function activity_order_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$mem_id = $this->get_bytoken($this->input->get_post('token', TRUE));
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Activities');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Activities->activity_order_list($mem_id, $start, $limit);
	
		encode_json($response,$data);
	}

	public function activity_order_detail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$order_no = $this->input->get_post('order_no', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Activities');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Activities->activity_order_detail($order_no);
	
		encode_json($response,$data);
	}

}