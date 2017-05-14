<?php  

class Classes_mission
{
	use date_format, struct;

	private $category = [
				['Video Learning' => 'is_view'],
				['Article learning' => 'is_view'],
				['Place your order' => 'isCountEnough', 'Make Transactions' => 'isCountEnough', 'Make Transaction 1' => 'isCountEnough', 'Make Transaction 2' => 'isCountEnough'],
				['4 style trade' => 'isCountEnough'],
				['take profits/stop loss' => 'isCountEnough'],
				['Trade all kinds products' => 'isCountEnough', 'Task 2 - 10 different products' => 'isCountEnough', '5 tradable products' => 'isCountEnough'],
				['Trading Record' => 'isCountEnough'],
				['Learning Report' => 'isCountEnough'],
				['Trading Score' => 'isCountEnough'],
				['Task 1 - 2 different markets' => 'isCountEnough'],
				['Produce a module' => 'isCountEnough'],
				['Risk Management Level' => 'isCountEnough'],
				['Profitable Period' => 'isCountEnough']
			];

	public $showData = ['Video Learning' => ['classes_text', 'id, class_id, name, image'], 'Article learning' => ['article', 'id, title']];

	private $mission;

	private $homework;

	private $complete;

	private $missionCount = 0;

	private $completeOne = [];

	public function init($mission = null, $homework = null)
	{
		$this->mission = $mission;
		$this->homework = $homework;
		$this->missionCount = count($mission);
		return $this;
	}

	public function get_mission_complete()
	{
		$method = [];
		$homework = [];

		array_walk($this->homework, function ($val, $key) use (&$homework) {
			$homework[$key] = $val;
		});

		array_walk_recursive($this->category, function ($val, $key) use (&$method, $homework) {
			foreach ($homework as $k => $v) {
				if ($k == $key) {
					$method[$val][$k] = $v;
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

	private function is_view($param)
	{
		foreach ($this->mission as $key => $value) {
			if (!empty($param[$key])) {
				$this->completeOne[$key] = 1;
				$this->complete += empty(array_diff($value, $param[$key])) ? 1 : 0;
			}
		}
	}

	private function isCountEnough($param)
	{
		foreach ($this->mission as $key => $value) {
			if (!empty($param[$key])) {
				$this->completeOne[$key] = 1;
				$this->complete += ($param[$key] >= $value) ? 1 : 0;
			}
		}
	}

}
