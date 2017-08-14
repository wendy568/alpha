<?php
/**
	 /`._______________________________________________________________
	|       ,  ,--.                            _____   ,^.             |
	|     _/ \ |  |___   ______     __ ,--._ /  ____ \(___)  :::  :::  | 
	|   /   _/ |   _  \ /   ,-.`,--|  ' _   |  |  ,-' |   |            | 
	|__|   ‘__/'  | |  |   ‘-‘ /  /|  |  |  |  |___\  \   |____________|
	    \ ____/|__| |__|\ ______ / |__|  |__|\ ______^._`，]
 */
class Consult extends MY_Controller
{

	public function get_bytoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken($token);
		return $data;
	}

	public function get_bytoken_id($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken_id($token);
		return $data;
	}

	public function get_bytoken_id_forAdmin($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('admins');
		$data = $this->admins->get_bytoken_id($token);
		return $data;
	}

	public function get_byadmintoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('admins');
		$data = $this->admins->get_bytoken($token);
		return $data;
	}

	public function add_consult()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$this->get_byadmintoken($token);
		$datas['from_id'] = $this->get_bytoken_id_forAdmin($token);
		$datas['create_time'] = date('Y-m-d H:i:s', time());
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['content'])) $datas['content'] = addslashes($datas['content']);
		if(!empty($datas['title'])) $datas['title'] = addslashes($datas['title']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$this->load->model('consults');
		$image = null;
		if(!empty($datas['width']) && !empty($datas['height'])) $image = get_image($datas['width'], $datas['height'], 'consults');

		if($image) $datas['image'] = addslashes(json_encode(array('consults/'.json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));
		$dfdb = databases_filter::build();
		$cols = array($datas['table']);
		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->insert_complete($cols);

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data = array();
		$data['data'] = $this->consults->add_consult($cols, $response);
	
		encode_json($response,$data);
	}

	public function show_consults_onZone()
	{
		header( 'Access-Control-Allow-Origin:*' );
			
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
		$this->load->helper('return_time');
		$time = return_time::build();

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->show_consults_onZone($time);
	
		encode_json($response,$data);
	}

	public function show_banner()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$page = $this->input->get_post('page', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->show_banner($page);
	
		encode_json($response,$data);
	}

	public function show_ad()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$page = $this->input->get_post('page', TRUE);
		$position = $this->input->get_post('position', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->show_ad($page, $position);
	
		encode_json($response,$data);
	}

	public function add_form()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['from_id'] = $this->get_bytoken($token);
		$datas['create_time'] = date('Y-m-d H:i:s', time());
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['content'])) $datas['content'] = addslashes($datas['content']);
		if(!empty($datas['title'])) $datas['title'] = addslashes($datas['title']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$this->load->model('consults');
		$image = null;
		if(!empty($datas['width']) && !empty($datas['height'])) $image = get_image($datas['width'], $datas['height'], 'form');

		if($image) $datas['image'] = addslashes(json_encode(array('form/'.json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));
		$dfdb = databases_filter::build();
		$cols = array('form');
		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->insert_complete($cols);

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data = array();
		$data['data'] = $this->consults->add_consult($cols, $response);
	
		encode_json($response,$data);
	}

	public function show_formForTrader()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$navi_id = $this->input->get_post('navi_id', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->show_formForTrader($mem_id, $navi_id);
	
		encode_json($response,$data);
	}

	public function update_consult()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$this->get_byadmintoken($token);
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['content'])) $datas['content'] = addslashes($datas['content']);
		if(!empty($datas['title'])) $datas['title'] = addslashes($datas['title']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);

		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$image = null;
		if(!empty($datas['width']) && !empty($datas['height'])) $image = get_image($datas['width'], $datas['height'], 'consults');

		if($image) $datas['image'] = addslashes(json_encode(array('consults/'.json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));
		$dfdb = databases_filter::build();
		$cols = array($datas['table']);

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->update_complete($cols, array($datas['table']=>array('id'=>$datas['id'])));
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('consults');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->update_consult($cols, $response, $datas['id']);

		encode_json($response, $data);
	}

	public function update_form()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$this->get_byadmintoken($token);
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['content'])) $datas['content'] = addslashes($datas['content']);
		if(!empty($datas['title'])) $datas['title'] = addslashes($datas['title']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);

		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$image = null;
		if(!empty($datas['width']) && !empty($datas['height'])) $image = get_image($datas['width'], $datas['height'], 'form');

		if($image) $datas['image'] = addslashes(json_encode(array('form/'.json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));
		$dfdb = databases_filter::build();
		$cols = array('form');

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->update_complete($cols, array('form'=>array('id'=>$datas['id'])));
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('consults');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->update_consult($cols, $response, $datas['id']);

		encode_json($response, $data);
	}

	public function delete_consult()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$id = $this->input->get_post('id', TRUE);
		$table = $this->input->get_post('table', TRUE);
		$this->get_byadmintoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->consults->delete_consult($id, $table);
	
		encode_json($response,$data);
	}

	public function list_forConsult()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$table = $this->input->get_post('table', TRUE);
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		$this->get_byadmintoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->list_forConsult($start, $limit, $table);
	
		encode_json($response,$data);
	}

	public function detail_forConsult()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$table = $this->input->get_post('table', TRUE);
		$id = $this->input->get_post('id', TRUE);
		$this->get_byadmintoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->detail_forConsult($id, $table);
	
		encode_json($response,$data);
	}

	public function list_forNews()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->list_forNews($start, $limit);
	
		encode_json($response,$data);
	}

	public function detail_forNews()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$id = $this->input->get_post('id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->detail_forNews($id);
	
		encode_json($response,$data);
	}

	public function list_forActivity()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		$navi_id = $this->input->get_post('navi_id', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->list_forActivity($start, $limit, $navi_id);
	
		encode_json($response,$data);
	}

	public function show_activity_onTrader()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->show_activity_onTrader($start, $limit);
	
		encode_json($response,$data);
	}

	public function detail_forActivity()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$id = $this->input->get_post('id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->detail_forActivity($id);
	
		encode_json($response,$data);
	}

	public function show_navigation()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('consults');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->consults->show_navigation();
	
		encode_json($response,$data);
	}
}