<?php
class Utility extends MY_Controller
{
	public function week_news()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$account = $this->get_trading_account($token);
		$left_right = $this->input->get_post('left_right', TRUE);
		$time_node = $this->input->get_post('time_node', TRUE);

		$start = '+3';
		$nextOrLast = '+0';
		if($left_right == 'left') {
			$start = '-1';
		} elseif($left_right == 'right') {
			$start = '+1';
			$nextOrLast = '+6';
		}

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->helper('encapsulation');
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->news();

		$this->load->library('trading_datas_calculate');
		$this->trading_datas_calculate->time_filter_definition = 'time';
		$data['data']['news'] = $this->trading_datas_calculate->build($mt4, 3)->property('setUnixTime', [$start, $nextOrLast, $time_node])->get_week()->getWeekResult();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
		encode_json($response,$data);
	}

	public function addTradingLog()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['from_id'] = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('sql_operation');
		$this->load->library('trading_log');

		$cols = $this->trading_log->format($datas)->init()-create_time()->update_time()->property('user_addslashes')->add();

		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->add($cols, $response);
	
		encode_json($response,$data);
	}
}


