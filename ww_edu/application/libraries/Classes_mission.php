<?php  

class Classes_mission
{
	use date_format, struct;

	protected $category;

	protected $distribution = [
				'Video Learning' => 'videoRead',
				'Video learning' => 'videoRead',
				'Article learning' => 'articleRead',
				'Place your order' => 'record_count', 'Make Transactions' => 'record_count', 'Make Transaction 1' => '', 'Make Transaction 2' => '',
				'4 style trade' => 'orderSymbolCount',
				'take profits/stop loss' => 'profits_loss',
				'Trade all kinds products' => 'record_count', 'Task 2 - 10 different products' => 'record_count', '5 tradable products' => 'record_count',
				'Trading Record' => 'record_count',
				'Learning Report' => '',
				'Trading Score' => 'ability',
				'Task 1 - 2 different markets' => 'specCountProc',
				'Produce a module' => '',
				'Risk Management Level' => 'variance',
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

	public $showData = ['Video Learning' => ['classes_text', 'id, class_id, name, image'], 'Article learning' => ['article', 'id, title']];

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

		array_walk($homework, function ($val, $key) use (&$homework) {
			$homework[$key] = $val;
		});

		array_walk($this->category, function ($val, $key) use (&$method, $homework) {
			foreach ($homework as $k => $v) {
				if ($k == $key) {
					if($val) $method[$val][$k] = $v;
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
		foreach ($this->mission as $key => $value) {
			if (!empty($param[$key])) {
				$this->completeOne[$key] = empty(array_diff($value, $param[$key])) ? 1 : 0;
				$this->complete += empty(array_diff($value, $param[$key])) ? 1 : 0;
			}
		}
	}

	protected function isCountEnough($param)
	{
		foreach ($this->mission as $key => $value) {
			if (isset($param[$key])) {
				$this->completeOne[$key] = ($param[$key] >= $value) ? 1 : 0;
				$this->complete += ($param[$key] >= $value) ? 1 : 0;
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

	protected function read($param)
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

	protected function count($callback, $param)
	{
		$instance = & get_instance();
		$instance->load->database();
		$instance->load->model('TradingAnalysis');
		$count = call_user_func_array([$instance->TradingAnalysis, $callback], [$param]);

		if ($count === 0) return false;
		foreach ($param as $key => $value) {
			$this->homework[$key] = $count;
		}

		return $this->homework;
	}

	protected function videoRead($param)
	{
		if($this->look_up != 'video') return false;
		call_user_func_array([$this, 'read'], [$param]);
	}

	protected function articleRead($param)
	{
		if($this->look_up != 'article') return false;
		call_user_func_array([$this, 'read'], [$param]);
	}

	protected function record_count($param)
	{
		// call_user_func_array([$this, 'count'], ['trading_count', [$param]]);
	}

	protected function orderSymbolCount($param)
	{
		print_r([$param, 'order_type', '0,1,2,3,4,5', 'order_type']);die;
		call_user_func_array([$this, 'count'], ['trading_count', [$param, 'order_type', '0,1,2,3,4,5', 'order_type']]);
	}

	protected function specCountProc($param)
	{
		call_user_func_array([$this, 'count'], ['trading_count', [$param, 'order_type', '0,1,2,3,4,5', 'order_type']]);
	}

}
