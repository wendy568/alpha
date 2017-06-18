<?php
class Remark extends MY_Controller
{
	public function add_remark()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['uid'] = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('sql_operation');
		$this->load->library('sample_struct');

		$cols = $this->sample_struct->init($datas, 'remark')->create_time()->format()->property('user_addslashes',[])->pickUpProperty()->add();
		print_r($cols);die;
		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->add($cols, $response);
		$data['time'] = time();
		
		encode_json($response,$data);
	}

	public function update_remark()
	{

		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['uid'] = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('sql_operation');
		$this->load->library('sample_struct');

		$cols = $this->sample_struct->init($datas, 'remark')->format()->property('user_addslashes', [])->pickUpProperty()->update();
		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->add($cols, $response);
		$data['time'] = time();

		encode_json($response,$data);
	}
}