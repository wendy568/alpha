<?php
class Remark extends MY_Controller
{
	public function list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->input->get_post('uid', TRUE);
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		$admin_id = $this->get_byadmintoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('remarks');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->remarks->list($uid, $start, $limit);
	
		encode_json($response,$data);
	}

	public function delete_remark()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$id = $this->input->get_post('id', TRUE);
		$admin_id = $this->get_byadmintoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('remarks');
		
		$data['data'] = [];
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->remarks->delete_remark($id);
	
		encode_json($response,$data);
	}
// curl --form file=@/Users/chenqi/www/1499240666.mp4 "http://upload.jwplatform.com/v1/videos/upload?api_format=json&key=vtQmcboj& token=e2bbad0fd889d5d2e30047596cfe3789778257d2"
// curl --request PUT --upload-file /Users/chenqi/www/1499240666.mp4 "https://jwplatform-upload.s3-accelerate.amazonaws.com/tL17msiU?AWSAccessKeyId=AKIAIRXCJ3TPZA4HVNYZ&Expires=1482770374&Signature=1%2Fl%2BL6%2FyOE05dNEbXHW8sw7TGF4%3D"
	public function add_remark()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$admin_id = $this->get_byadmintoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('sql_operation');
		$this->load->library('sample_struct');

		$cols = $this->sample_struct->init($datas, 'remark')->create_time()->format()->property('user_addslashes',[])->pickUpProperty()->add();

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
		$admin_id = $this->get_byadmintoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('sql_operation');
		$this->load->library('sample_struct');

		$cols = $this->sample_struct->init($datas, 'remark')->format()->property('user_addslashes', [])->pickUpProperty()->update();
		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->update($cols, $response);
		$data['time'] = time();

		encode_json($response,$data);
	}
}