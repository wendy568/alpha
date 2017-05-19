<?php  
/**
 	MT4 Order Datas

	order_no: 订单号
	account_number: 账户号
	order_symbol: 货币对
	order_type: 买卖方向
	order_lots: 交易手数
	order_open_price: 开仓价格
	order_open_time: 开仓时间
	order_close_price: 平仓价格
	order_close_time: 平仓时间
	order_take_profit: 止盈
	order_stop_loss: 止损
	profit:盈利
 */
class Trading_datas_calculate {

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

	public function setUnixTime($start, $nextOrLast = '+0', $time = null)
	{
		var_dump(strtotime(date('Y-m-d', strtotime(date('Y-m-d', $time) . " {$start} day")) . " {$nextOrLast} day"));
		$time = isset($time) ? $time : time();
		//date('Y-m-d', strtotime(date('Y-m-d', strtotime(date('Y-m-d', $time) . " {$start} day")) . " {$nextOrLast} day"))
		$this->unix_time = strtotime(date('Y-m-d', strtotime(date('Y-m-d', $time) . " {$start} day")) . " {$nextOrLast} day");
	}

	public function get_week()
	{
		print_r($this->unix_time);
		$datas = $this->_data;
		$result = [];
		$instance = & get_instance();
		$instance->load->helper('time_zone');
		$week = time_zone::build()->get_week($this->unix_time);
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
						$result[$month . '.' . $day][] = $value;
					} 

					if(!isset($result[$month . '.' . $day])) {
						$result[$month . '.' . $day] = [];
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
				$result[$month . '.' . $day] = [];
			}
		}

		$this->oneByone = $result;
		return $this;
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

    	return $sum;
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
    	return $avg;
    }

    //Avg[∑(CloseTime-OpenTime)]
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

    //TimeNow-AccountOpentTime
    public function transaction_peroid($index)
    {
    	return time() - current($this->_data)[$index];
    }

    //根号[∑((X-μ)^2)] ? A (A*B) X=Profit μ=Avg(∑Profit) A=Count(OrderNo(Profit>0))/Count(OrderNo)  B=Avg(Profit)
    public function variance($index)
    {
    	$datas = $this->_data;
    	$avg = call_user_func_array([$this, 'avg'], [$index, $this->_data]);
    	$sum = 0;
    	foreach ($datas as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k == $index) {
					$sum += pow(($v - $avg), 2);
				}
			}
		}

		return round(sqrt($sum), 2);

    }

    //trading 专属方法,数据意义不明所以
    public function frequency($callback, $param)
    {
    	$denominator = call_user_func_array([$this, $callback], $param);
    	$frequency = ($denominator) ? $this->count / $denominator : 0;
    	return round(($frequency) * 300, 4);
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

    //A=Count(OrderNo(Profit>0))/Count(OrderNo) 
    public function accuracy($index)
    {
    	$accuracy = ($this->count) ? $this->count_positive($index) / $this->count : 0;
    	return  round($accuracy, 4);
    }

    //(A*B) A=Count(OrderNo(Profit>0))/Count(OrderNo)  B=Avg(Profit)
    public function ability($index)
    {
    	return round($this->accuracy($index) * $this->avg($index, $this->_data), 4);
    }

    //只处理枚举
    //Count(OrderNo(OrderType=0))/Count(OrderNO(OrderType=1)) 
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

}