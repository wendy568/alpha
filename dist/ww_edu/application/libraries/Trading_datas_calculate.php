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

	private $import_datas = null;

	private $mt4_order_datas = array(
				'BuyNo' => null,
				'SellNo' => null,
				'SingleGain' => null,
				'Singleloss' => null,
				'Singlelots' => null,
				'AvgTime' => null,
				'AvgGain' => null,
				'Avgloss' => null,
				'Period' => null,
				'GLRatio' => null,
				'LSRatio' => null,
				'ProfitLots' => null,
				'BestSymbol' => null,
				'RiskManage' => null,
		);

	public function __get($name){
        if(isset($this->mt4_order_datas[$name])) {
            return $this->mt4_order_datas[$name];
        } elseif(isset($this->import_datas)) {
        	echo 123;
        }
        return null;
    }

    public function __set($name,$value){
        if(isset($this->mt4_order_datas[$name])) {
            $this->mt4_order_datas[$name] = $value;
        } elseif(isset($this->import_datas)) {
        	echo 123;
        }
    }

    public function __isset($name){
        return isset($this->mt4_order_datas[$name]);
    }

    public function BuyNo()
    {
    	return $this;
    }
}