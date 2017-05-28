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

	private $mt4;

	private $account_number;
	private $order_symbol;
	private $order_type;
	private $order_lots;
	private $order_open_price;
	private $order_open_time;
	private $order_close_price;
	private $order_close_time;
	private $order_take_profit;
	private $order_stop_loss;
	private $profit;
	private $ceate_time;
	private $update_time;
	private $order_no;

	public function build($import_datas)
	{
		$this->mt4 = $import_datas;
		extract($this->mt4, EXTR_PREFIX_SAME, "cq");
		echo $profit;
	}

	//Count(OrderNo(OrderType=0))+Count(OrderNo(OrderType=1))
    public function trading_count()
    {
    	$this->buy_count = count($this->mt4);
    }
}