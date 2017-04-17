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
class Trading_datas_calculate{

	// private $import_datas = array(
	// 			'mt4' => array()
	// 	);

	private $analysis = array(
				'buy_count'      => null,
				'sell_count'     => null,
				'single_gain' => null,
				'single_loss' => null,
				'single_lots' => null,
				'avg_time'    => null,
				'avg_gain'    => null,
				'avg_loss'    => null,
				'period'     => null,
				'gl_ratio'    => null,
				'ls_ratio'    => null,
				'profit_lots' => null,
				'best_symbol' => null,
				'risk_manage' => null,
		);

	public function __get($name){
        // if(isset($this->import_datas[$name])) {
        //     return $this->import_datas[$name];
        // }

        if(isset($this->analysis[$name])) {
        	var_dump($name);
            return $this->analysis[$name] = $value;
        }

        return null;
    }

    public function __set($name,$value){
        // if(isset($this->import_datas[$name])) {
        //     $this->import_datas[$name] = $value;
        // }

        if(isset($this->analysis[$name])) {
        	var_dump($name);
            $this->analysis[$name] = $value;
        }
    }

    public function __isset($name){
        return isset($this->analysis[$name]);
    }

    // public function buy_no()
    // {
    // 	$this->buy_count = 123;
    // }
}