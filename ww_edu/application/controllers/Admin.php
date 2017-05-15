<?php

class Admin extends MY_Controller
{
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

	public function Login()
	{
		header( 'Access-Control-Allow-Origin:*' );
		$data = array();
		$username = $this->input->get_post('username', TRUE);
		$password = $this->input->get_post('password', TRUE);
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('admins');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->admins->login($username, $password, $response, $data);
		
		encode_json($response,$data);
	}

	public function update()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$this->get_byadmintoken($token);
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['content'])) $datas['content'] = addslashes($datas['content']);
		if(!empty($datas['title'])) $datas['title'] = addslashes($datas['title']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);
		if(!empty($datas['act_info'])) $datas['act_info'] = addslashes($datas['act_info']);

		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$image = null;

		if(!empty($datas['width']) && !empty($datas['height'])) $image = get_image($datas['width'], $datas['height'], "{$datas['file_path']}");
		if($image) $datas['image'] = addslashes(json_encode(array("{$datas['file_path']}/".json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));

		$dfdb = databases_filter::build();
		$cols = array($datas['table']);

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->update_complete($cols, array($datas['table']=>array('id'=>$datas['id'])));
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('admins');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->admins->update($cols, $response);

		encode_json($response, $data, 201);
	}

	public function add()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();

		$this->get_byadmintoken($token);
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['content'])) $datas['content'] = addslashes($datas['content']);
		if(!empty($datas['title'])) $datas['title'] = addslashes($datas['title']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);
		if(!empty($datas['act_info'])) $datas['act_info'] = addslashes($datas['act_info']);

		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$image = null;

		if(!empty($datas['width']) && !empty($datas['height'])) $image = get_image($datas['width'], $datas['height'], "{$datas['file_path']}");
		if($image) $datas['image'] = addslashes(json_encode(array("{$datas['file_path']}/".json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));

		$dfdb = databases_filter::build();
		$cols = array($datas['table']);

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->insert_complete($cols);
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('admins');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->admins->add($cols, $response);

		encode_json($response, $data, 201);
	}

	public function delete()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$id = $this->input->get_post('id', TRUE);
		$table = $this->input->get_post('table', TRUE);
		$this->get_byadmintoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('admins');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['bool'] = $this->admins->delete($id, $table);
		$code = ($data['data']['bool']) ? 200 : 204;
		encode_json($response,$data, $code);
	}
}