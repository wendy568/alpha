<?php

class time_zone{

	protected $_date;

	public static function build() {
        return new time_zone();
    }

    public function lastDayInMonthOfBegin()
	{
		return $this->_date = strtotime(date('Y-m-01', strtotime(date('Y-m-d', time()))));
	}

	public function lastDayInMonthOfEnd()
	{
		return $this->_date = strtotime(date('Y-m-01', strtotime(date('Y-m-d', time()))) . ' +1 month -1 day');
	}

	public function sundayOfTheWeekOfBegin()
	{
		$time = getdate();
		if($time['wday'] != 1 && $time['wday'] != 0) {
			$day = $time['wday'] - 1;
			$_date = strtotime(" - {$day} day");
		} elseif ($time['wday'] == 1) {
			$_date = $time[0];
		} elseif ($time['wday'] == 0) {
			$_date = strtotime(" - 6 day");
		}

		$year = date("Y", $_date);
		$month = date("m", $_date);
		$day = date("d", $_date);

		return $this->_date = mktime(00,00,00,$month,$day,$year);
	}

	public function sundayOfTheWeekOfEnd()
	{
		$time = getdate();
		if($time['wday'] != 0) {
			$day = 7 - $time['wday'];
			$_date = strtotime(" + {$day} day");
		} elseif ($time['wday'] == 0) {
			$_date = $time[0];
		}

		$year = date("Y", $_date);
		$month = date("m", $_date);
		$day = date("d", $_date);

		return $this->_date = mktime(23,59,59,$month,$day,$year);
	}

	public function theDayStart($val)
	{
		$slice = explode('-', $val);
		$year = $slice[0];
		$month = $slice[1]; 
		$day = $slice[2];
		$start = mktime(00, 00, 00, $month, $day, $year);

		return $this->_date = $start;
	}

	public function theDayEnd($val)
	{
		$slice = explode('-', $val);
		$year = $slice[0];
		$month = $slice[1]; 
		$day = $slice[2];
		$end = mktime(23, 59, 59, $month, $day, $year);

		return $this->_date = $end;
	}

	public function todayBegin()
	{
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$end= mktime(00,00,00,$month,$day,$year);

		return $this->_date = $end;
	}

	public function todayEnd()
	{
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$end= mktime(23,59,59,$month,$day,$year);

		return $this->_date = $end;
	}

	public function get_week($time = null)
	{
		$time = ($time) ? $time : time();
		$date = getdate($time);
		$dates = [];
		$this_month = ($date['mon'] < 10) ? '0' . $date['mon'] : $date['mon'];
		$this_year = $date['year'];
		if($date['mday'] < 7) {
			$slice = explode('-', date('Y-m-d', strtotime(date('Y-m-01', strtotime(date('Y-m-d', $time))) . ' -1 day')));
			$year = $slice[0];
			$month = $slice[1];
			$j = 0;
			for ($i = 1; $i <= 7; $i++) { 
				if (($slice[2] - (7 - $date['mday'] - $i)) <= $slice[2]) {
					$day = $slice[2] - (7 - $date['mday'] - $i);
				} else {
					$j = $j + 1;
					$day = '0' . $j;
					$month = $this_month;
					$year = $this_year;
				}
				$dates[] = "{$year}-{$month}-{$day}";
			}

			return $this->_date = $dates;

		} elseif ($date['mday'] >= 7) {
			$year = date("Y", $time);
			$month = date("m", $time);
			for ($i = 0; $i < 7; $i++) { 
				$day = $date['mday'] - $i;
				$day = (strlen($day) <2) ? '0' . $day : $day;
				$dates[] = "{$year}-{$month}-{$day}";
			}

			return array_reverse($dates);
		}
	}

	public function get_time_zone()
	{
		return $this->_date;
	}
}