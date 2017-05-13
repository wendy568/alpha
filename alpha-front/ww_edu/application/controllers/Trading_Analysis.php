<?php
class Trading_Analysis extends MY_Controller
{
	public function calculator_anytime()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$start_time = $this->input->get_post('start_time', TRUE);
		$end_time = $this->input->get_post('end_time', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->helper('encapsulation');
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account, $finency_proc, $start_time, $end_time);
		$this->load->library('trading_datas_calculate');
		$data['data']['risk_management_level'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('variance', ['profit'])->get_property();
		$data['data']['operating_frequecy'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('frequency', ['avg_deviation', ['order_open_time', 'order_close_time']])->get_property();
		$data['data']['operating_accuracy'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('accuracy', ['profit'])->get_property();
		$data['data']['trading_ability'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('ability', ['profit'])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}

	public function profit_loss()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$start_time = $this->input->get_post('start_time', TRUE);
		$end_time = $this->input->get_post('end_time', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->helper('encapsulation');
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account, $finency_proc, $start_time, $end_time);
		$this->load->library('trading_datas_calculate');
		$data['data']['profit_total'] = $this->trading_datas_calculate->build($mt4, 3)->property('sum', ['profit'])->get_property();
		$data['data']['profit'] = $this->trading_datas_calculate->build($mt4, 3)->saveCountPositive('profit')->property('sum', ['profit'])->get_property();
		$data['data']['loss'] = $data['data']['profit_total'] - $data['data']['profit'];

		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}

	public function profit_curve()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$start_time = $this->input->get_post('start_time', TRUE);
		$end_time = $this->input->get_post('end_time', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->helper('encapsulation');
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account, $finency_proc, $start_time, $end_time);
		$this->load->library('trading_datas_calculate');

		$data['data']['profit_week'] = $this->trading_datas_calculate->build($mt4, 3)->get_week()->property('get_one_by_one', ['sum', ['profit']])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}

	public function numberOfTransations()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$start_time = $this->input->get_post('start_time', TRUE);
		$end_time = $this->input->get_post('end_time', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->helper('encapsulation');
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account, $finency_proc, $start_time, $end_time);
		$this->load->library('trading_datas_calculate');

		$data['data']['numbers_ratio'] = $this->trading_datas_calculate->build($mt4, 3)->get_week()->property('get_one_by_one', ['ratio', ['order_type']])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}

	public function long_short_ratio()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$start_time = $this->input->get_post('start_time', TRUE);
		$end_time = $this->input->get_post('end_time', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->helper('encapsulation');
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account, $finency_proc, $start_time, $end_time);
		$this->load->library('trading_datas_calculate');
		$data['data']['percent_ratio'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('percent_ratio', ['order_type'])->get_property();
		
		$response = array('archive' => array('status' => 0 ,'message' =>''));

		encode_json($response,$data);
	}

	public function allTradingStatistics()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$start_time = $this->input->get_post('start_time', TRUE);
		$end_time = $this->input->get_post('end_time', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->helper('encapsulation');
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account, $finency_proc, $start_time, $end_time);
		$this->load->library('trading_datas_calculate');
		$data['data']['Net_profit'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('sum', ['profit'])->get_property();
		$data['data']['Average_Profits'] = $this->trading_datas_calculate->build($mt4, 3)->saveCountPositive('profit')->count()->property('avg', ['profit'])->get_property();
		$data['data']['Average_Loss'] = $this->trading_datas_calculate->build($mt4, 3)->saveCountNegative('profit')->count()->property('avg', ['profit'])->get_property();
		$data['data']['Maximum_Consecutive_Profit'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('Consecutive', ['profit'])->get_property();
		$data['data']['Avg_holding_Time'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('avg_deviation', ['order_open_time', 'order_close_time'])->get_property();
		$data['data']['risk_management_level'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('variance', ['profit'])->get_property();

		$response = array('archive' => array('status' => 0 ,'message' =>''));

		encode_json($response,$data);
	}

	public function trading_history()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$start_time = $this->input->get_post('start_time', TRUE);
		$end_time = $this->input->get_post('end_time', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->helper('encapsulation');
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account, $finency_proc, $start_time, $end_time);
		$this->load->library('trading_datas_calculate');
		$data['data']['trading_history'] = $this->trading_datas_calculate->build($mt4, 3)->count()->get_result();
		
		$response = array('archive' => array('status' => 0 ,'message' =>''));

		encode_json($response,$data);
	}

}