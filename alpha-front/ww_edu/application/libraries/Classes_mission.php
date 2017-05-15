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
				'4 style trade' => 'record_count',
				'take profits/stop loss' => 'record_count',
				'Trade all kinds products' => 'record_count', 'Task 2 - 10 different products' => 'record_count', '5 tradable products' => 'record_count',
				'Trading Record' => 'record_count',
				'Learning Report' => '',
				'Trading Score' => 'ability',
				'Task 1 - 2 different markets' => 'specCountProc',
				'Produce a module' => '',
				'Risk Management Level' => 'variance',
				'Profitable Period' => 'sumOneMonth'
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
		return $this->complete / $this->missionCount;
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

	protected function videoRead($param)
	{
		foreach ($param as $key => $value) {
			$return = array_search($this->public_params, $this->mission[$key]);
			print_r($this->mission[$key]);
			print_r($return);
		}
			
		
	}

	protected function articleRead($param)
	{

	}

	protected function record_count($param)
	{

	}

}
