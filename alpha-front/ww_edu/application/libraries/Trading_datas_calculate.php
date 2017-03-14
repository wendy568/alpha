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
	
	private $time_filter_definition = 'order_close_time';

	public $oneByone = '';

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

		return $this;
	}

	public function get_result()
	{
		return $this->_data;
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

	public function get_day()
	{
		$datas = $this->_data;
		foreach ($datas as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k == $this->time_filter_definition) {
					$year = date('Y', $v);
					$month = date('m', $v);
					$day = date('d', $v);

					if ($year == $this->this_year && $month == $this->this_month && $day != $this->this_day) {
						unset($datas[$key]);
					}
				}
			}
		}

		$this->_data = $datas;
		unset($datas);

		return $this;
	}

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

	public function get_week()
	{
		$datas = $this->_data;
		$result = [];
		$instance = & get_instance();
		$instance->load->helper('time_zone');
		$week = time_zone::build()->get_week();
		
		foreach ($datas as $key => $value) {
			foreach ($value as $k => $v) {
				foreach ($week as $val) {
					$slice = explode('-', $val);
					$year = $slice[0];
					$month = $slice[1]; 
					$day = $slice[2];
					$start = mktime(00, 00, 00, $month, $day, $year);
					$end = mktime(23, 59, 59, $month, $day, $year);
					if ($k == $this->time_filter_definition && $v >= $start && $v <= $end) {
						$result[$val][] = $value;
					} 

					if(!isset($result[$val])) {
						$result[$val] = [];
					}
				}
			}
		}

		$this->oneByone = $result;
		return $this;
	}

    public function get_one_by_one($callback, $param)
    {
    	foreach ($this->oneByone as $key => $value) {
    		$param['data'] = $value;
    		$result[$key] = call_user_func_array([$this, $callback], $param);
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
    	if(isset($data)) $datas = $data;

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

    	$avg = $sum / $this->count;
    	return $avg;
    }

    //Avg[∑(CloseTime-OpenTime)]
    public function avg_holding($start, $end)
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

    	return floor($sum / $this->count);
    }

    //TimeNow-AccountOpentTime
    public function transaction_peroid($index)
    {
    	return time() - current($this->_data)[$index];
    }

    //根号[∑((X-μ)^2)] ? A (A*B) X=Profit μ=Avg(∑Profit) A=Count(OrderNo(Profit>0))/Count(OrderNo)  B=Avg(Profit)
    public function variance()
    {
    	$datas = $this->_data;
    	$avg = call_user_func_array([$this, 'avg'], ['profit', $this->_data]);
    	$sum = 0;
    	foreach ($datas as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k == 'profit') {
					$sum += pow(($v - $avg), 2);
				}
			}
		}

		return sqrt($sum);

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

    //A=Count(OrderNo(Profit>0))/Count(OrderNo) 
    public function accuracy($index)
    {
    	return  $this->count_positive($index) / $this->count;
    }

    //(A*B) A=Count(OrderNo(Profit>0))/Count(OrderNo)  B=Avg(Profit)
    public function ability($index)
    {
    	return $this->accuracy($index) * $this->avg($index, $this->_data);
    }

}