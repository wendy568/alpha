<?php
class Dashboard extends MY_Controller
{
	public function previews_since_today()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account);
		$this->load->library('trading_datas_calculate');
		$data['data']['trading_count'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('get_count', [])->get_property();
		$data['data']['last_trading_count'] = "100% Higher";
		$data['data']['profit'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('sum', ['profit'])->get_property();
		$data['data']['last_profit'] = "100% Higher";
		$data['data']['avg_holding_time'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('avg_deviation', ['order_open_time', 'order_close_time'])->get_property();
		$data['data']['last_avg_holding_time'] = "100% Higher";

		$data['data']['transaction_peroid'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('transaction_peroid', ['order_open_time'])->get_property();
		$data['data']['last_transaction_peroid'] = "100% Higher";

		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}

	public function profit_statistics()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account);
		$this->load->library('trading_datas_calculate');
		$data['data']['profit_total'] = $this->trading_datas_calculate->build($mt4, 3)->property('sum', ['profit'])->get_property();
		$data['data']['profit_today'] = $this->trading_datas_calculate->build($mt4, 3)->get_day()->property('sum', ['profit'])->get_property();
		$data['data']['profit_month'] = $this->trading_datas_calculate->build($mt4, 3)->get_month()->property('sum', ['profit'])->get_property();
		$data['data']['profit_week'] = $this->trading_datas_calculate->build($mt4, 3)->get_week()->property('get_one_by_one', ['sum', ['profit']])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}

	public function trading_evaluating()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account);
		$this->load->library('trading_datas_calculate');
		$data['data']['risk_management_level'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('variance', ['profit'])->get_property();
		$data['data']['operating_frequecy'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('frequency', ['avg_deviation', ['order_open_time', 'order_close_time']])->get_property();
		$data['data']['operating_accuracy'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('accuracy', ['profit'])->get_property();
		$data['data']['trading_ability'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('ability', ['profit'])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
	
		encode_json($response,$data);
	}

	public function long_short_ratio()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$finency_proc = $this->input->get_post('finency_proc', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->export_mt4_datas($account, $finency_proc);
		$this->load->library('trading_datas_calculate');
		$data['data']['percent_ratio'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('percent_ratio', ['order_type'])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
		encode_json($response,$data);
	}

	public function calendar()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$start_time = $this->input->get_post('start_time', TRUE);
		$end_time = $this->input->get_post('end_time', TRUE);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->calendar($start_time, $end_time);
		$this->load->library('trading_datas_calculate');
		// $data['data']['calendar'] = $this->trading_datas_calculate->build($mt4, 3)->count()->get_result();
		$data['data']['calendar'] = $this->trading_datas_calculate->build($mt4, 3)->property('setUnixTime', ['+1'])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
		encode_json($response,$data);
	}
}