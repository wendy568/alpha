<?php  
class Admin_index extends MY_Controller
{
	public function index()
	{
		$this->load->database();
		$this->load->model('admin');
		$this->load->helper('url');
		$this->load->helper('menu');

		$data['admin_name'] = $this->admin->get_bytoken($_SESSION['admin_id']);
		$this->load->view('admin/layout/header',$data);
		$this->load->view('admin/index',$data);
		$this->load->view('admin/layout/footer',$data);
		
	}

	public function business()
	{
		$this->load->database();
		$this->load->model('admin');
		$this->load->helper('url');
		$this->load->helper('menu');
		$this->load->model('business');
		$data['datas'] = $this->business->show();
		$data['admin_name'] = $this->admin->get_bytoken($_SESSION['admin_id']);
		$this->load->view('admin/layout/header',$data);
		$this->load->view('admin/business/edit',$data);
		$this->load->view('admin/layout/footer',$data);
		
	}

	public function image($width, $height)
	{
		$this->load->helper('url');
		$this->load->helper('set_source');
		$data = get_image($width,$height);
		echo $data;
	}

	public function edit_business()
	{
		$data = array();
		$this->load->database();
		list($title, $describe, $image) = array(
				$this->input->post_get('title',TRUE),
				$this->input->post_get('describe',TRUE),
				$this->input->post_get('image',TRUE)
			);

		foreach($title as $key=>$tit)
		{
			$data[$key]['title'] = $tit;
			$data[$key]['describe'] = $describe[$key];
			$data[$key]['image'] = $image[$key];
		}

		$this->load->model('business');
		$this->business->edit($data);
	}

}