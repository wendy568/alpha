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
		
		$this->load->helper('encapsulation');
		$this->load->library('trading_datas_calculate');
		$last_month = getdate(strtotime(date('Y-m-d H:i:s', time()) . '- 1 month'))['mon'];
		print_r($last_month);
		$data['data']['trading_count'] = $this->trading_datas_calculate->build($mt4)->get_month()->count()->property('get_count', [])->get_property();
		$last_trading_count = $this->trading_datas_calculate->build($mt4, $last_month)->get_month()->count()->property('get_count', [])->get_property();
		$abs = $data['data']['trading_count'] - $last_trading_count;
		$desc = ($abs > 0) ? ' Higher' : ' Lower';
		$data['data']['last_trading_count'] = round(abs($abs) / $last_trading_count, 1);
		var_dump($last_trading_count);
		$data['data']['profit'] = $this->trading_datas_calculate->build($mt4)->get_month()->count()->property('sum', ['profit'])->get_property();
		$last_profit = $this->trading_datas_calculate->build($mt4, $last_month)->get_month()->count()->property('sum', ['profit'])->get_property();
		$abs = $data['data']['profit'] - $last_profit;
		$desc = ($abs > 0) ? ' Higher' : ' Lower';
		$data['data']['last_profit'] = round(abs($abs) / $last_profit, 1);
		var_dump($last_profit);
		$data['data']['avg_holding_time'] = $this->trading_datas_calculate->build($mt4)->get_month()->count()->property('avg_deviation', ['order_open_time', 'order_close_time'])->get_property();
		$last_avg_holding_time = $this->trading_datas_calculate->build($mt4, $last_month)->get_month()->count()->property('avg_deviation', ['order_open_time', 'order_close_time'])->get_property();
		$abs = $data['data']['avg_holding_time'] - $last_avg_holding_time;
		$desc = ($abs > 0) ? ' Higher' : ' Lower';
		$data['data']['last_avg_holding_time'] = round(abs($abs) / $last_avg_holding_time, 1);
		var_dump($last_avg_holding_time);
		$data['data']['transaction_peroid'] = $this->trading_datas_calculate->build($mt4)->get_month()->count()->property('transaction_peroid', ['order_open_time'])->get_property();
		$last_transaction_peroid = $this->trading_datas_calculate->build($mt4, $last_month)->get_month()->count()->property('transaction_peroid', ['order_open_time'])->get_property();
		$abs = $data['data']['transaction_peroid'] - $last_transaction_peroid;
		var_dump($last_transaction_peroid);
		$data['data']['last_transaction_peroid'] = round(abs($abs) / $last_transaction_peroid, 1);

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
		$this->load->helper('encapsulation');
		$this->load->library('trading_datas_calculate');
		$data['data']['profit_total'] = $this->trading_datas_calculate->build($mt4)->property('sum', ['profit'])->get_property();
		$data['data']['profit_today'] = $this->trading_datas_calculate->build($mt4)->get_day()->property('sum', ['profit'])->get_property();
		$data['data']['profit_month'] = $this->trading_datas_calculate->build($mt4)->get_month()->property('sum', ['profit'])->get_property();
		$data['data']['profit_week'] = $this->trading_datas_calculate->build($mt4)->get_week()->property('get_one_by_one', ['sum', ['profit']])->get_property();
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
		$this->load->helper('encapsulation');
		$this->load->library('trading_datas_calculate');
		$data['data']['risk_management_level'] = $this->trading_datas_calculate->build($mt4)->count()->property('variance', ['profit'])->get_property();
		$data['data']['operating_frequecy'] = $this->trading_datas_calculate->build($mt4)->count()->property('frequency', ['avg_deviation', ['order_open_time', 'order_close_time']])->get_property();
		$operating_accuracy = $this->trading_datas_calculate->build($mt4)->count()->property('accuracy', ['profit'])->get_property();
		$data['data']['operating_accuracy'] = round($operating_accuracy * 100, 2);
		$data['data']['trading_ability'] = $this->trading_datas_calculate->build($mt4)->count()->property('ability', ['profit'])->get_property();
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
		$this->load->helper('encapsulation');
		$this->load->library('trading_datas_calculate');
		$data['data']['percent_ratio'] = $this->trading_datas_calculate->build($mt4, 3)->count()->property('percent_ratio', ['order_type'])->get_property();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
		encode_json($response,$data);
	}

	public function calendar()
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
		$this->load->model('TradingAnalysis');

		$mt4 = $this->TradingAnalysis->calendar();		
		$this->load->helper('encapsulation');
		$this->load->library('trading_datas_calculate');
		$this->trading_datas_calculate->time_filter_definition = 'time_cn';
		$data['data']['calendar'] = $this->trading_datas_calculate->build($mt4)->property('setUnixTime', [$start, $nextOrLast, $time_node])->get_week('align_time','align_top')->getWeekResult();
		$response = array('archive' => array('status' => 0 ,'message' =>''));
		encode_json($response,$data);
	}

	public function news()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$account = $this->get_trading_account($token);

		$this->load->database();
		$this->load->helper('json');
		// $this->load->helper('time_zone');
		// date('Y-m-d H:i:s', time_zone::build()->sundayOfTheWeekOfEnd()->get_time_zone());die;
		$this->load->model('TradingAnalysis');

		$date = getdate();
		$mt4 = $this->TradingAnalysis->news();		
		$this->load->helper('encapsulation');
		$this->load->library('trading_datas_calculate');
		$this->trading_datas_calculate->time_filter_definition = 'time';
		$data['data']['news'] = $this->trading_datas_calculate->build($mt4, 5)->get_month()->get_result();
		$data['data']['date'] = $date[0];
		$response = array('archive' => array('status' => 0 ,'message' =>''));

		encode_json($response,$data);
	}

	function test()
	{
		print_r(array_diff([],['b' => 1,2,3,4]));die;
		$homework = [
			['Video Learning' => [1, 2, 3, 4], 'Article learning' => [1, 2, 3, 4]],
			['Video learning' => [1, 2], 'Article learning' => [1, 2], 'Place your order' => 1, '4 style trade' => [1, 2, 3, 4], 'take profits/stop loss' => 2],
			['Make Transactions' => 20, 'Trade all kinds products'=> 15, 'Trading Record' => 1, 'Learning Report' => 1],
			['Video Learning' => [1, 2, 3], 'Article learning' => [1, 2, 3], 'Make Transaction 1' => 1, 'Make Transaction 2' => 1],
			['Video Learning' => [1, 2, 3], 'Article learning' => [1, 2, 3], 'Make Transactions' => 3],
			['Make Transactions' => 30, 'Task 1 - 2 different markets' => 2, 'Task 2 - 10 different products' => 10, 'Trading Record' => 1, 'Learning Report' => 1],
			['5 tradable products' => 5, 'Trading Record' => 1],
			['Produce a module' => 1, 'Learning Report' => 1],
			['Article learning' => [1, 2, 3], 'Risk Management Level' => 30],
			['Risk Management Level' => 60, 'Trading Score' => 30, 'Trading Record' => 1],
			['Video Learning' => [1, 2, 3], 'Article learning' => [1, 2, 3]],
			['Trading Score' => 60, 'Learning Report' => 1],
			['Trading Score' => 60, 'Learning Report' => 1],
			['Trading Score' => 60, 'Learning Report' => 1],
			['Trading Score' => 60, 'Profitable Period' => 3]
		];
		foreach ($homework as $key => $value) {
			print_r(json_encode($value));
			echo "\n";
		}
			
	}
}