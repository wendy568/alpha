<?php  
/**
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
class Trading_datas_calculate
{
	private $calculate_datas;

	private $mt4_datas;

	public function __construct($mt4_datas)
	{
		$this->mt4_datas = $mt4_datas;
		$this->calculate_datas = $calculate_datas;
	}

	public function BuyNo()
	{
		return $this;
	}
}