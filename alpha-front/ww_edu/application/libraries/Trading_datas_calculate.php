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

	private $mt4 = [];
	private $trading_count = 0;
	private $this_month;

	public function build($import_datas)
	{
		$this->mt4 = $import_datas;
		$this->this_month = getdate()['mon'];
		print_r($this->this_month);
		return $this;
	}

	//Count(OrderNo(OrderType=0))+Count(OrderNo(OrderType=1))
    public function trading_count()
    {
    	$this->trading_count = count($this->mt4);
    }

    public function profit_since_today()
    {
    	$sum = 0;
    	array_walk_recursive($this->mt4, function ($val, $key) use (&$sum){
    		if ($key == 'profit') {
    			$sum += $val;
    		}
    	});

    	$this->profit = $sum;
    }


}