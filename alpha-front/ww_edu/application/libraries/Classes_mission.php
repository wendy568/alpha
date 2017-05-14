<?php  

class Classes_mission
{
	use date_format, struct;

	protected $category;

	protected $distribution = [
				'Video Learning' => 'read',
				'Video learning' => 'read',
				'Article learning' => 'read',
				'Place your order' => 'isCountEnough', 'Make Transactions' => 'isCountEnough', 'Make Transaction 1' => '', 'Make Transaction 2' => '',
				'4 style trade' => 'isCountEnough',
				'take profits/stop loss' => 'isCountEnough',
				'Trade all kinds products' => 'isCountEnough', 'Task 2 - 10 different products' => 'isCountEnough', '5 tradable products' => 'isCountEnough',
				'Trading Record' => 'isCountEnough',
				'Learning Report' => '',
				'Trading Score' => 'isCountEnough',
				'Task 1 - 2 different markets' => 'isCountEnough',
				'Produce a module' => '',
				'Risk Management Level' => 'isCountEnough',
				'Profitable Period' => 'isCountEnough'
			];

	public $showData = ['Video Learning' => ['classes_text', 'id, class_id, name, image'], 'Article learning' => ['article', 'id, title']];

	protected $classes;

	protected $mission;

	protected $homework;

	public $public_params;

	protected $complete;

	protected $missionCount = 0;

	protected $completeOne = [];

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
		$homework = [];

		array_walk($this->homework, function ($val, $key) use (&$homework) {
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
		var_dump(empty(0));
		foreach ($this->mission as $key => $value) {
			if (!empty($param[$key])) {
				$this->completeOne[$key] = ($param[$key] >= $value) ? 1 : 0;
				print_r($this->completeOne);
				$this->complete += ($param[$key] >= $value) ? 1 : 0;
			}
		}
	}

	protected function read($param)
	{

	}

}
