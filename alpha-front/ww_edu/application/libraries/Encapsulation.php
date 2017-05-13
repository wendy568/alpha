<?php  

abstract class Encapsulation
{
	private $_data = [];

	private $_property = [];

	private $count = 0;

	private $this_month;

	private $this_year;

	private $this_day;
	
	public $time_filter_definition = 'order_close_time';

	private $unix_time;

	private $oneByone = '';

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

		public function get_result()
		{
			return $this->_data;
		}

		public function getWeekResult()
		{
			return $this->oneByone;
		}

		public function get_property()
		{
			return $this->property;
		}

		public function count()
		{
			$this->count = count($this->_data);
			return $this;
		}

		private function get_count()
		{
			return $this->count;
		}

		public function get_day()
		{
			$datas = $this->_data;
			foreach ($datas as $key => $value) {
				foreach ($value as $k => $v) {
					if ($k == $this->time_filter_definition) {
						$month = date('m', $v);
						$day = date('d', $v);
						if ($month != $this->this_month OR $day != $this->this_day) {
							unset($datas[$key]);
						}
					}
				}
			}

			$this->_data = $datas;
			unset($datas);

			return $this;
		}
		//只判断今年
		public function get_month()
		{
			$datas = $this->_data;
			foreach ($datas as $key => $value) {
				foreach ($value as $k => $v) {
					if ($k == $this->time_filter_definition && getdate($v)['mon'] != $this->this_month) {
						unset($datas[$key]);
					}
				}
			}

			$this->_data = $datas;
			unset($datas);

			return $this;
		}

		private function putInNewCol($callback, $index, $newIndex = 'position')
		{
			foreach ($this->_data as $key => $value) {
					foreach ($value as $k => $v) {
						if ($k == $index) {
							if($callback) $value[$newIndex] = call_user_func_array([$this, $callback], [$v]);
							$this->_data[$key] = $value;
						}
					}
			}

			return $this->_data;
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

		public function getRealWeek()
		{
			$datas = $this->_data;

		}

		public function put_in()
		{
			$this->_data = [];
			$index = 0;
			foreach ($this->oneByone as $key => $value) {
				if (!empty($value)) {
					foreach ($value as $k => $v) {
						$this->_data[$index] = $v;
						$index += 1;
					}
				}
			}

			return $this;
		}

	    public function get_one_by_one($callback, $param)
	    {
	    	foreach ($this->oneByone as $key => $value) {
	    		if (!empty($value)) {
	    			$param['data'] = $value;
	    			$result[$key] = call_user_func_array([$this, $callback], $param);
	    		} else {
	    			$result[$key] = null;
	    		}
	    		
	    	}

	    	return $result;
	    }

	    public function property($callback, $param)
	    {
	    	$this->property = call_user_func_array([$this, $callback], $param);
	    	return $this;
	    }

	    private function align_time($value)
	    {
	    	$time = date('G');
			if($time == date('G', $value)){
				return 1;
			} else {
				return 0;
			}    	
	    }

	    private function sum($index, $data = [])
	    {
	    	$datas = $this->_data;
	    	if(!empty($data)) $datas = $data;

	    	$sum = 0;
	    	array_walk_recursive($datas, function ($val, $key) use (&$sum, $index){
	    		if ($key == $index) {
	    			$sum += $val;
	    		}
	    	});

	    	return round($sum, 2);
	    }

	    private function avg($index, $data = [])
	    {
	    	$datas = $this->_data;
	    	$avg = 0;
	    	$sum = 0;
	    	array_walk_recursive($datas, function ($val, $key) use (&$sum, $index){
	    		if ($key == $index) {
	    			$sum += $val;
	    		}
	    	});

	    	$avg = ($this->count) ? $sum / $this->count : 0;
	    	return round($avg, 2);
	    }

	    public function avg_deviation($start, $end)
	    {
	    	$datas = $this->_data;
	    	$sum = 0;
	    	foreach ($datas as $key => $value) {
	    		foreach ($value as $k => $v) {
	    			if($k == $start) {
	    				$open = $v;
	    			}

	    			if($k == $end) {
	    				$close = $v;
	    			}
	    		}
	    		$sum += $close - $open;
	    	}

	    	return ($this->count) ? floor($sum / $this->count) : 0;
	    }

	    private function count_positive($index)
	    {
	    	$datas = $this->_data;
	    	foreach ($datas as $key => $value) {
				foreach ($value as $k => $v) {
					if ($k == $index && $v < 0) {
						unset($datas[$key]);
					}
				}
			}
			return count($datas);
	    }

	    public function saveCountPositive($index)
	    {
	    	$datas = $this->_data;
	    	foreach ($datas as $key => $value) {
				foreach ($value as $k => $v) {
					if ($k == $index && $v < 0) {
						unset($datas[$key]);
					}
				}
			}
			$this->_data = $datas;
			return $this;
	    }

	    public function saveCountNegative($index)
	    {
	    	$datas = $this->_data;
	    	foreach ($datas as $key => $value) {
				foreach ($value as $k => $v) {
					if ($k == $index && $v > 0) {
						unset($datas[$key]);
					}
				}
			}
			$this->_data = $datas;
			return $this;
	    }



	    //只处理枚举
	    public function percent_ratio($index)
	    {
	    	$datas = $this->_data;
	    	$count = $this->count;
	    	$ratio = [];
	    	$array = array_count_values(array_column($datas, $index));
	    	array_walk($array, function ($val, $key) use (&$ratio, $count){
	    		$ratio['_' . $key] = ($count) ? round($val / $count, 2) : 0;
	    	});

	    	return $ratio;
	    }

	    //只处理枚举
	    public function ratio($index, $data = [])
	    {
	    	$datas = $this->_data;

	    	if(!empty($data)) $datas = $data;

	    	$array = array_count_values(array_column($datas, $index));
	    	foreach ($array as $key => $value) {
	    		$array['_' . $key] = $value;
	    		unset($array[$key]);
	    	}
	    	
	    	return $array;
	    }

	    public function Consecutive($index, $data = null)
	    {
	    	$datas = $this->_data;
	    	if($data) $datas = $data;
	    	$count = [];
	    	$sum = 0;
	    	foreach ($datas as $key => $value) {
	    		foreach ($value as $k => $v) {
	    			if ($k == $index && $v > 0) {
	    				$sum += 1;
	    			} elseif($k == $index && $v < 0) {
	    				if($sum !== 0 && $sum !== 1) $count[] = $sum;
	    				$sum = 0;
	    			}
	    		}
	    	}

	    	if($sum !== 0 && $sum !== 1) $count[] = $sum;
	    	rsort($count);
	    	return current($count);
	    }

}