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
	private $trading_count = 0;
	private $this_month;
	private $this_year;
	private $week = '';
	private $time_filter_definition = 'order_close_time';

	public function build($import_datas, $month = null, $year = null)
	{
		$this->_data = $import_datas;

		if ($month !== null) {
			$this->this_month = $month;
		} else {
			$this->this_month = getdate()['mon'];
		}

		if ($year !== null) {
			$this->this_year = $year;
		} else {
			$this->this_year = getdate()['year'];
		}

		return $this;
	}

	public function get_result()
	{
		return $this->_data;
	}

	public function get_property($prop)
	{
		return $this->property[$prop];
	}

	public function get_year()
	{
		$datas = $this->_data;
		foreach ($datas as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k == $this->time_filter_definition && getdate($v)['year'] != $this->this_year) {
					unset($datas[$key]);
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

		$this->week = $result;
		return $this;
	}

	//Count(OrderNo(OrderType=0))+Count(OrderNo(OrderType=1))
    public function trading_count()
    {
    	$this->trading_count = count($this->_data);
    }

    public function profit()
    {
    	if (isset($this->week)) {
    		# code...
    	}
    	$sum = 0;
    	array_walk_recursive($this->_data, function ($val, $key) use (&$sum){
    		if ($key == 'profit') {
    			$sum += $val;
    		}
    	});

    	$this->property['profit'] = $sum;
    	return $this;
    }

    //Avg[∑(CloseTime-OpenTime)]
    public function avg_holding()
    {

    }

    //TimeNow-AccountOpentTime
    public function transaction_peroid()
    {

    }

}