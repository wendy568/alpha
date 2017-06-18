<?php  

class Classes_mission
{
	use date_format, Trading_calculate, struct;

	protected $category;

	protected $distribution = [
				'Video Learning' => 'videoRead',
				'Video learning' => 'videoRead',
				'Article learning' => 'articleRead',
				'Place your order' => 'record_count', 'Make Transactions' => 'record_count', 'Make Transaction 1' => '', 'Make Transaction 2' => '',
				'4 style trade' => 'orderSymbolCount',
				'take profits/stop loss' => 'profits_loss',
				'Trade all kinds products' => 'TradingManyProducts', 'Task 2 - 10 different products' => 'TradingManyProducts', '5 tradable products' => 'TradingManyProducts',
				'Trading Record' => 'userLogsCount',
				'Learning Report' => '',
				'Trading Score' => 'homework_ability',
				'Task 1 - 2 different markets' => 'specCountProc',
				'Produce a module' => '',
				'Risk Management Level' => 'homework_variance',
				'Profitable Period' => 'sumOneMonth'
			];

	protected $products = [
				[
					'AUDUSD', 'EURUSD', 'GBPUSD', 'NZDUSD', 'USDCAD', 'USDCHF', 'USDCNH', 'USDJPY', 'AUDCAD', 'AUDCHF', 'AUDJPY', 'AUDNZD', 'CADCHF', 'CADJPY', 'CHFJPY', 'EURAUD', 'EURCAD', 'EURCHF', 'EURGBP', 'EURJPY', 'EURNZD', 'GBPAUD', 'GBPCAD', 'GBPCHF', 'GBPJPY', 'GBPNZD', 'NZDJPY'],
		  		[
					'XAUUSD', 'XAGUSD', 'DXY', 'COPPER', 'NGAS', 'UKOIL', 'USOIL'
				],
				[
					'AUS200', 'HKG50', 'HKH40', 'JPN225', 'NAS100', 'SPX500', 'UK100', 'US30'
				]
			];

	public $showData = ['Video Learning' => ['classes_text', 'id, class_id, name, image'], 'Video learning' => ['classes_text', 'id, class_id, name, image'], 'Article learning' => ['article', 'id, title, image']];

	protected $classes;

	protected $mission;

	protected $homework;

	public $public_params;

	protected $complete;

	protected $missionCount = 0;

	protected $completeOne = [];

	protected $needRecord = [];

	public $look_up = null;

	public $account;

	public $uid;

	public $time;

	public function init($mission = null, $homework = null, $allProcess = null)
	{
		$this->classes = $allProcess;
		$this->mission = $mission;
		$this->homework = $homework;
		$this->missionCount = count($mission);

		return $this;
	}

	public function get_distribution()
	{
		$this->category = $this->distribution;
		return $this;
	}

	public function getLastOrNextProcess()
	{
		return $this->lastOrNextProcess;
	}

	public function generating()
	{
		$result = [];

		foreach($this->classes as $key => $value) {
			foreach ($this->jsonDecode($value['homework']) as $k => $v) {
				$v = is_array($v) ? 'is_view' : $v;
				$v = is_numeric($v) ? 'isCountEnough' : $v;
				$result[$k] = $v;
			}
		}
		
		$this->category = $result;

		return $this;
	}

	public function get_mission_complete()
	{
		$method = [];
		$homework = $this->homework;
		if (!empty($this->needRecord)) $homework = $this->needRecord;

		array_walk($this->category, function ($val, $key) use (&$method, $homework) {
			foreach ($homework as $k => $v) {
				if ($k == $key) {
					if ($val) $method[$val][$k] = $v;
				}
			}
		});

		$this->method = $method;

		return $this;
	}

	public function complete_ratio()
	{
		return round($this->complete / $this->missionCount, 2);
	}

	public function get_homework()
	{
		return $this->homework;
	}

	public function learnOneComplete()
	{
		$this->completeOne = null;
		return $this;
	}

	public function getOneComplete()
	{
		return $this->completeOne;
	}

	public function distributing()
	{
		foreach ($this->method as $key => $value) {
			$result[$key] = call_user_func_array([$this, $key], [$value]);
		}
	}

	protected function is_view($param)
	{
		foreach ($param as $key => $value) {
			if (!empty($this->mission[$key])) {
				$this->completeOne[$key] = empty(array_diff($this->mission[$key], $value)) ? 1 : 0;
				$this->complete += empty(array_diff($this->mission[$key], $value)) ? 1 : 0;
			}
		}
	}

	protected function isCountEnough($param)
	{
		foreach ($param as $key => $value) {
			if (isset($this->mission[$key])) {
				$this->completeOne[$key] = ($value >= $this->mission[$key]) ? 1 : 0;
				$this->complete += ($value >= $this->mission[$key]) ? 1 : 0;
			}
		}
	}

	public function intersection()
	{
		foreach ($this->lastOrNextProcess as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $kk => $val) {
					foreach ($val as $k => $v) {
						if ($k == 'id' && ($bool = array_search($v, $this->homework[$key]) OR $bool !== false)) {
							$this->lastOrNextProcess[$key][$kk]['is_complete'] = 1;
						}
					}					
				}
			} 

			if (is_numeric($value)) {
				$this->lastOrNextProcess[$key] = $this->homework[$key] . '/' . $value;
			}
		}

		return $this->lastOrNextProcess;
	}

	public function make_complete($current_mission, $personal, $mission_key = null)
	{
		$mission_key = explode(',', $mission_key);
		foreach ($mission_key as $key) {
			if (isset($key) && $key) {
				if (!empty($personal[$key]) OR @$personal[$key] === 0) {
					if (is_numeric($personal[$key])) $personal[$key] = ($current_mission[$key] > $personal[$key]) ? $current_mission[$key] : $personal[$key];
				
					if (is_array($personal[$key])) $personal[$key] = $current_mission[$key];
				}
			}

		}
		
		return $personal;
	}

	public function skipAGrade($current_mission, $mission_key = null)
	{
		$mission_key = explode(',', $mission_key);

		foreach ($current_mission as $key => $value) {
			if (!($index = array_search($key, $mission_key)) && $index === false) {
				if (is_array($value)) $current_mission[$key] = [];
				if (is_numeric($value)) $current_mission[$key] = 0;
			}
		}

		return $current_mission;
	}

	public function clean_mission($mission)
	{
		foreach ($mission as $key => $value) {
			if (is_array($value)) $mission[$key] = [];
			if (is_numeric($value)) $mission[$key] = 0;
		}

		return $mission;
	}

	public function record_history($current_stage, $stage_id, $history, $personal = null, $allProcess = null)
	{
		var_dump($current_stage);
		var_dump($stage_id);
		print_r($history);
		print_r($personal);
		print_r($allProcess);

		if (($num = $stage_id - $current_stage) > 0) {
			$history[$current_stage . '_'] = $personal;
			for ($current_stage; $current_stage < $stage_id; $current_stage++) {
				foreach ($allProcess as $value) {
					if ($value['id'] == $current_stage + 1 && $current_stage + 1 != $stage_id) {
						$history[($current_stage + 1) . '_'] = $this->clean_mission(json_decode($value['homework'], true));
					}
				}
			}
		} else if ($num === 0) {
			$history[$current_stage . '_'] = $personal;
		} else if ($num < 0) {
			$history[$stage_id . '_'] = $personal;
		}

		print_r($history);
	}

	public function lastOrNextProcess()
	{
		$instance = & get_instance();
		$instance->load->database();
		$instance->load->model('ClassesM');
		
		$mission = $this->mission;
		foreach ($this->showData as $key => $value) {
			if (!empty($mission[$key])) {
				$ids = implode(',', $mission[$key]);
				unset($mission[$key]);
				$mission[$key] = $instance->ClassesM->showData($ids, $value[0], $value[1]);
			}
		}

		$this->lastOrNextProcess = $mission;

		return $this;
	}

	public function is_complete($is)
	{
		$this->needRecord = $this->homework;
		foreach ($is as $key => $value) {
			if ($value == 1) {
				unset($this->needRecord[$key]);
			}
		}

		return $this;
	}

	protected function homework_read($param)
	{
		foreach ($param as $key => $value) {
			if (($is_mission = array_search($this->public_params, $this->mission[$key])) OR $is_mission !== false) {
				if (!($bool = array_search($this->mission[$key][$is_mission], $value)) && $bool === false) {
				 	$param[$key][] = $this->mission[$key][$is_mission];
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		
		foreach ($param as $key => $value) {
			$this->homework[$key] = $value;
		}

		return $this->homework;
	}

	protected function homework_count($callback, $param, $model, $query)
	{
		$instance = & get_instance();
		$instance->load->database();
		$instance->load->model($model);
		$count = call_user_func_array([$instance->$model, $callback], $query);

		if ($count === 0) return false;
		foreach ($param as $key => $value) {
			$this->homework[$key] = $count;
		}

		return $this->homework;
	}

	protected function load_datas($callback, $model, $query)
	{
		$instance = & get_instance();
		$instance->load->database();
		$instance->load->model($model);
		$this->_data = call_user_func_array([$instance->$model, $callback], $query);

		return $this->_data;
	}

	protected function videoRead($param)
	{
		if($this->look_up != 'video') return false;
		call_user_func_array([$this, 'homework_read'], [$param, $this->time]);
	}

	protected function articleRead($param)
	{
		if($this->look_up != 'article') return false;
		call_user_func_array([$this, 'homework_read'], [$param, $this->time]);
	}

	protected function record_count($param)
	{
		call_user_func_array([$this, 'homework_count'], ['trading_count', $param, 'TradingAnalysis', [$this->account, $this->time]]);
	}

	protected function orderSymbolCount($param)
	{
		call_user_func_array([$this, 'homework_count'], ['tradingCountGroup', $param, 'TradingAnalysis', [$this->account, 'order_type', $this->time]]);
	}

	protected function profits_loss($param)
	{
		call_user_func_array([$this, 'homework_count'], ['tradingCountGL', $param, 'TradingAnalysis', [$this->account, ['order_take_profit', 'order_stop_loss'], $this->time]]);
	}

	protected function specCountProc($param)
	{
		call_user_func_array([$this, 'homework_count'], ['tradingCountIn', $param, 'TradingAnalysis', [$this->account, 'order_symbol', $this->products, $this->time]]);
	}

	protected function TradingManyProducts($param)
	{
		call_user_func_array([$this, 'homework_count'], ['tradingCountGroup', $param, 'TradingAnalysis', [$this->account, 'order_symbol', $this->time]]);
	}

	protected function userLogsCount($param)
	{
		call_user_func_array([$this, 'homework_count'], ['logs_count', $param, 'Trading_logs', [$this->uid, $this->time]]);
	}

	protected function homework_ability($param)
	{
		call_user_func_array([$this, 'load_datas'], ['export_mt4_datas', 'TradingAnalysis', [$this->account, null, null, null, $this->time]]);

		$count = $this->count()->property('ability', ['profit'])->get_property();

		if ($count === 0) return false;
		foreach ($param as $key => $value) {
			$this->homework[$key] = $count;
		}

		return $this->homework;
	}

	protected function homework_variance($param)
	{
		call_user_func_array([$this, 'load_datas'], ['export_mt4_datas', 'TradingAnalysis', [$this->account, null, null, null, $this->time]]);
		// $this->count()->property('frequency', ['avg_deviation', ['order_open_time', 'order_close_time']])->get_property();die;
		$count = $this->count()->property('variance', ['profit'])->get_property();
		if ($count === 0) return false;
		foreach ($param as $key => $value) {
			$this->homework[$key] = $count;
		}

		return $this->homework;
	}

	protected function sumOneMonth($param)
	{
		$count = 0;
		$mt4 = call_user_func_array([$this, 'load_datas'], ['export_mt4_datas', 'TradingAnalysis', [$this->account, null, null, null, $this->time]]);
		foreach ($param as $key => $null) {
			for ($i = 0; $i < $this->mission[$key]; $i++) {
				$mon = getdate($this->time)['mon'];
				$mon = $mon + $i;
				$profit = $this->build($mt4,$mon)->get_month()->property('sum', ['profit'])->get_property();
				$count += ($profit > 0) ? 1 : 0;
			}
		}
		if ($count === 0) return false;
		foreach ($param as $key => $value) {
			$this->homework[$key] = $count;
		}

		return $this->homework;
	}

}
