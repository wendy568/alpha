<?php  

trait struct
{
	protected $_data = [];

	protected $_property = [];

	protected $count = 0;

	protected $this_month;

	protected $this_year;

	protected $this_day;
	
	public $time_filter_definition = '';

	protected $unix_time;

	protected $oneByone = '';
	
	public function get_property()
	{
		return $this->property;
	}

	public function count()
	{
		$this->count = count($this->_data);
		return $this;
	}

	protected function get_count()
	{
		return $this->count;
	}

	public function getWeekResult()
	{
		return $this->oneByone;
	}

	public function build($import_datas, $month = null)
	{
		$this->_data = $import_datas;

		if ($month !== null) {
			$this->this_month = ($month < 10) ? '0' . $month : $month;
		} else {
			$this->this_month = (getdate()['mon'] < 10) ? '0' . getdate()['mon'] : getdate()['mon'];
		}

		$this->this_year = getdate()['year'];

		$this->this_day = (getdate()['mday'] < 10) ? '0' . getdate()['mday'] : getdate()['mday'];

		$this->unix_time = time();

		return $this;
	}

	public function setUnixTime($start, $nextOrLast = '+0', $time = null)
	{
		$time = (isset($time) && $time) ? $time : time();
		//date('Y-m-d', strtotime(date('Y-m-d', strtotime(date('Y-m-d', $time) . " {$start} day")) . " {$nextOrLast} day"))
		$this->unix_time = strtotime(date('Y-m-d', strtotime(date('Y-m-d', $time) . " {$start} day")) . " {$nextOrLast} day");
	}

	public function get_week($callback = null, $index = 'position')
	{
		$datas = $this->_data;
		$result = [];
		$instance = & get_instance();
		$instance->load->helper('time_zone');
		$time_zone = time_zone::build();
		$week = $time_zone->get_week($this->unix_time);

		foreach ($datas as $key => $value) {
			foreach ($value as $k => $v) {
				foreach ($week as $val) {
					$slice = explode('-', $val);
					$year = $slice[0];
					$month = $slice[1]; 
					$day = $slice[2];
					$start = mktime(00, 00, 00, $month, $day, $year);
					$end = mktime(23, 59, 59, $month, $day, $year);
					if ($k == $this->time_filter_definition && ($v >= $start && $v <= $end)) {
						if($callback) $value[$index] = call_user_func_array([$this, $callback], [$v]);
						$result[$year . '.' . $month . '.' . $day][] = $value;
					} 

					if(!isset($result[$year . '.' . $month . '.' . $day])) {
						$result[$year . '.' . $month . '.' . $day] = [];
					}
				}
			}
		}

		if(empty($result)) {
			foreach ($week as $val) {
				$slice = explode('-', $val);
				$year = $slice[0];
				$month = $slice[1]; 
				$day = $slice[2];
				$result[$year . '.' . $month . '.' . $day] = [];
			}
		}

		$this->oneByone = $result;
		return $this;
	}

	public function property($callback, $param = null)
	{
		$this->property = call_user_func_array([$this, $callback], $param);
		return $this;
	}
}