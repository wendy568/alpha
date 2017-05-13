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

	private $mission;

	private $homework;

	private $videoId;

	private $articleId;

	private $complete;

	private $missionCount = 0;

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
		var_dump($$this->missionCount);
		print_r($method);
	}

	private function is_view()
	{
		$diff1 = $this->mission['Video Learning'];
		$diff2 = $this->homework['Video Learning'];

		return $this->complete = empty(array_diff($diff1, $diff2)) ? 1 : 0;
	}

}
