<?php

class return_time{
	private $_time = array(
			'day'   => '',
			'yday'  => '',
			'mon'   => '',
			'min'   => '',
			'hour'  => '',
			'sec'   => '',
			'year'  => '',
			'_mon'  => ' month ago',
			'_day'  => ' day ago',
			'_min'  => ' minute ago',
			'_hour' => ' hour ago',
			'_sec'  => ' second ago',
			'_year' => ' year ago'
		);

	public static function build() {
        return new return_time();
    }

	public function __get($name){
        if(isset($this->_time[$name])) {
            return $this->_time[$name];
        }
        return null;
    }

    public function __set($name,$value){
        if(isset($this->_time[$name])) {
            $this->_time[$name]    =   $value;
        }
    }

    public function __isset($name){
        return isset($this->_time[$name]);
    }

    public function filter_time()
    {
    	$date = getdate();
    	if(($time = $date['year'] - $this->year) > 1) return $time.$this->_year;

    	if(($date['year'] - $this->year) == 1 && ($date['mon'] + 12 - $this->mon) > 12) return '1'.$this->_year;

    	if(($date['year'] - $this->year) == 1 && ($date['mon'] + 12 - $this->mon) <= 12) return (floor($this->yday/86400)).$this->_day;

    	if(($time = $date['yday'] - $this->day) != 0) return $time.$this->_day;

    	if(($time = $date['hours'] - $this->hour) != 0) return $time.$this->_hour;

    	if(($time = $date['minutes'] - $this->min) != 0) return $time.$this->_min;

    	if(($time = $date['minutes'] - $this->sec) != 0) return $time.$this->_sec;
    }
}










