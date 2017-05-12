<?php
class Home extends MY_Controller
{
	public function main()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$xxxx = $this->input->get_post('xxxx', TRUE);
		$yyyy = $this->input->get_post('yyyy', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('Homes');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->Homes->main($xxxx, $yyyy);
	
		encode_json($response,$data);
	}

	public function initialization()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->helper('json');
		$this->load->helper('constants');

		$const = constants::build();
		$initialization = $const->alphatrader['initialization'];

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = [];
	
		encode_json($response,$data);
	}
}