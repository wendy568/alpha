<?php  

trait struct
{
	public function setUnixTime($start, $nextOrLast = '+0', $time = null)
	{
		$time = (isset($time) && $time) ? $time : time();
		//date('Y-m-d', strtotime(date('Y-m-d', strtotime(date('Y-m-d', $time) . " {$start} day")) . " {$nextOrLast} day"))
		$this->unix_time = strtotime(date('Y-m-d', strtotime(date('Y-m-d', $time) . " {$start} day")) . " {$nextOrLast} day");
	}

	public function get_week($callback = null, $index = 'position')
	{
		$datas = $this->_data;
		print_r($datas);die;
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
}