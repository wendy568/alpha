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

	private $buy_count;
	private $sell_count;
	private $single_gain;
	private $single_loss;
	private $single_lots;
	private $avg_time;
	private $avg_gain;
	private $avg_loss;
	private $period;
	private $gl_ratio;
	private $ls_ratio;
	private $profit_lots;
	private $best_symbol;
	private $risk_manage;

	public function __construct($import_datas)
	{
		if ($import_datas['type'] == 'mt4') {
			$this->mt4 = $import_datas['data'];
		}
	}

    public function buy_no()
    {
    	$this->buy_count = count($this->mt4);
    }
}