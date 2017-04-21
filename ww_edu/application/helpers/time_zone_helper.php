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
		if($time['wday'] != 1)
		{
			$day = $time['wday']-1;
			$this->_date = strtotime(" - {$day} day");
		}elseif ($time['wday'] == 1) {
			$this->_date = $time[0];
		}
		return $this;
	}

	public function sundayOfTheWeekOfEnd()
	{
		$time = getdate();
		if($time['wday'] != 0)
		{
			$day = 7-$time['wday'];
			$this->_date = strtotime(" + {$day} day");
		}elseif ($time['wday'] == 0) {
			$this->_date = $time[0];
		}
		return $this;
	}

	public function todayBegin()
	{
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		// $start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
		$end= mktime(00,00,00,$month,$day,$year);//当天结束时间戳
		$this->_date = $end;
		return $this;
	}

	public function todayEnd()
	{
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		// $start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
		$end= mktime(23,59,59,$month,$day,$year);//当天结束时间戳
		$this->_date = $end;
		return $this;
	}

	public function get_time_zone()
	{
		return $this->_date;
	}
}