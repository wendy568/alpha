<?php

class time_zone{

	protected $_date;

	public static function build() {
        return new time_zone();
    }

    public function lastDayInMonthOfBegin()
	{
		$this->_date = strtotime(date('Y-m-01', strtotime(date('Y-m-d', time()))));
		return $this;
	}

	public function lastDayInMonthOfEnd()
	{
		$this->_date = strtotime(date('Y-m-01', strtotime(date('Y-m-d', time()))) . ' +1 month -1 day');
		return $this;
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
		$this->_date= mktime(00,00,00,$month,$day,$year);

		return $this;
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
		$this->_date= mktime(23,59,59,$month,$day,$year);

		return $this;
	}

	public function todayBegin()
	{
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$end= mktime(00,00,00,$month,$day,$year);
		$this->_date = $end;
		return $this;
	}

	public function todayEnd()
	{
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$end= mktime(23,59,59,$month,$day,$year);
		$this->_date = $end;
		return $this;
	}

	public function get_week()
	{
		$date = getdate();
		if($date['mday'] < 7) {
			$slice = explode('-', date('Y-m-d', strtotime(date('Y-m-01', strtotime(date('Y-m-d'))) . ' -1 day')));
			print_r($slice);
		}
	}

	public function get_time_zone()
	{
		return $this->_date;
	}
}