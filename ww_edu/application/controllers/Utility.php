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

	public function tradingLogList()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$uid = $this->get_bytoken($token);
		$left_right = $this->input->get_post('left_right', TRUE);
		$time_node = $this->input->get_post('time_node', TRUE);

		$start = '+0';
		$nextOrLast = '+0';
		if($left_right == 'left') {
			$start = '-1';
		} elseif($left_right == 'right') {
			$start = '+1';
			$nextOrLast = '+6';
		}

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('trading_logs');

		$this->load->helper('struct');
		$this->load->helper('sql_operation');
		$this->load->library('trading_log');

		$logs = $this->trading_logs->tradingLogList($uid);

		$data['data']['OverAll'] = $this->trading_log->build($logs)->count()->property('get_count', [])->get_property();
		$data['data']['trading_logs'] = $this->trading_log->build($logs)->property('setUnixTime', [$start, $nextOrLast, $time_node])->get_week()->getWeekResult();

		$response = array('archive' => array('status' => 0,'message' =>''));
	
		encode_json($response,$data);
	}

	public function addTradingLog()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['uid'] = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('sql_operation');
		$this->load->library('trading_log');

		$cols = $this->trading_log->init($datas)
								  ->create_time()
								  ->format()
					              ->property('user_addslashes',[]);
					              // ->add();
					              print_r($cols);die;

		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->add($cols, $response);
	
		encode_json($response,$data);
	}

	public function updateTradingLog()
	{

		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$datas['uid'] = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('struct');
		$this->load->helper('sql_operation');
		$this->load->library('trading_log');

		$cols = $this->trading_log->init($datas)
								  ->format()
					              ->property('user_addslashes', [])
					              ->update();

		$this->load->model('users');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->add($cols, $response);
		
		encode_json($response,$data);
	}
}


