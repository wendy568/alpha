<?php  

class Classes_mission
{
	use date_format, struct;

	private $category = [
				['Video Learning' => 'viewVideo'],
				['Article learning' => 'viewArticle'],
				['Place your order' => 'trading_count', 'Make Transactions' => 'trading_count', 'Make Transaction 1' => 'trading_count', 'Make Transaction 2' => 'trading_count'],
				['4 style trade' => ''],
				['take profits/stop loss' => ''],
				['Trade all kinds products' => '', 'Task 2 - 10 different products' => '', '5 tradable products' => ''],
				['Trading Record' => ''],
				['Learning Report' => ''],
				['Trading Score' => ''],
				['Task 1 - 2 different markets' => ''],
				['Produce a module' => ''],
				['Risk Management Level' => ''],
				['Profitable Period' => '']
			];

	private $mission;

	private $homework;

	private $videoId;

	private $articleId;

	public function init($mission = null, $homework = null)
	{
		$this->mission = $mission;
		$this->homework = $homework;
		return $this;
	}

	public function get_mission_complete()
	{
		$method = [];
		$homework = [];

		array_walk($this->homework, function ($val, $key) use (&$homework) {
			$homework[] = $key;
		});

		array_walk_recursive($this->category, function ($val, $key) use (&$method, $homework) {
			foreach ($homework as $value) {
				if ($value == $key) {
					$method[] = $val;
				}
			}
		});

		

		print_r($method);
	}

	private function viewVideo()
	{
		$diff1 = $this->mission['Video Learning'];
		$diff2 = $this->homework['Video Learning'];

		return empty(array_diff($diff1, $diff2)) ? 1 : 0;
	}

	private function viewArticle()
	{
		$diff1 = $this->mission['Article learning'];
		$diff2 = $this->homework['Article learning'];

		return empty(array_diff($diff1, $diff2)) ? 1 : 0;
	}

}
