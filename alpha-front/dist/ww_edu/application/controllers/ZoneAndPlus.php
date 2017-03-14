<?php
class ZoneAndPlus extends MY_Controller
{
	public function made_zone_info()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$array['location'] = $this->input->get_post('location', TRUE);
		$array['start'] = $this->input->get_post('start', TRUE);
		$array['limit'] = $this->input->get_post('limit', TRUE);
		$array['zone_type'] = $this->input->get_post('zone_type', TRUE);

		$this->load->helper('json');

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'][] = $array;
	
		encode_json($response,$data);
	}

	public function zonePlus_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
			
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ZoneAndPluses');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->ZoneAndPluses->zonePlus_list();
	
		encode_json($response,$data);
	}

	public function zone_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ZoneAndPluses');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->ZoneAndPluses->zone_list($start, $limit);
	
		encode_json($response,$data);
	}

	public function zone_order_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$mem_id = $this->get_bytoken($this->input->get_post('token', TRUE));
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ZoneAndPluses');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->ZoneAndPluses->zone_order_list($mem_id, $start, $limit);
	
		encode_json($response,$data);
	}

	public function zone_plus_order_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$mem_id = $this->get_bytoken($this->input->get_post('token', TRUE));
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ZoneAndPluses');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->ZoneAndPluses->zone_plus_order_list($mem_id, $start, $limit);
	
		encode_json($response,$data);
	}

	public function zone_order_detail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$order_no = $this->input->get_post('order_no', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ZoneAndPluses');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->ZoneAndPluses->zone_order_detail($order_no);
	
		encode_json($response,$data);
	}

	public function zone_plus_order_detail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$order_no = $this->input->get_post('order_no', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('ZoneAndPluses');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->ZoneAndPluses->zone_plus_order_detail($order_no);
	
		encode_json($response,$data);
	}
}