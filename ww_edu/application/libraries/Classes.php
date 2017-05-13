<?php  

class Classes
{
	use date_format;

	private $category = [
				['Video Learning'],
				['Article learning'],
				['Place your order', 'Make Transactions', 'Make Transaction 1', 'Make Transaction 2'],
				['4 style trade'],
				['take profits/stop loss'],
				['Trade all kinds products', 'Task 2 - 10 different products', '5 tradable products'],
				['Trading Record'],
				['Learning Report'],
				['Trading Score'],
				['Task 1 - 2 different markets'],
				['Produce a module'],
				['Risk Management Level'],
				['Profitable Period']
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

	private function viewVideo()
	{

	}


}
