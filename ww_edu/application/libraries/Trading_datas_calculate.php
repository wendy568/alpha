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
class Trading_datas_calculate extends Encapsulation{

    protected $score_zone = [
                    'risk_management' => [
                        [[100, 90], [0, 0.001], [0.0001]],
                        [[90, 60], [0.001, 0.01], [0.0005, 'minusOne']],
                        [[60, 10], [0.01, 0.21], [0.004, 'minusOne']],
                        [[10, 0], [0.21, 0.71], [0.05, 'minusOne']]
                    ],
                    'trade_frequency' => [
                        [[0, 10], [0, 0.0001], [0.00001]],
                        [[10, 25], [0.0001, 0.001], [0.00006, 'minusOne']],
                        [[25, 40], [0.001, 0.01], [0.0006, 'minusOne']],
                        [[40, 55], [0.01, 0.1], [0.006, 'minusOne']],
                        [[55, 70], [0.1, 1], [0.06, 'minusOne']],
                        [[70, 85], [1, 10], [0.6, 'minusOne']],
                        [[85, 100], [10, 100], [6, 'minusOne']]
                    ],
                    'profit_ability' => [
                        [[95, 100], [5, 500000], [10, 'getLog']],
                        [[90, 95], [1, 5], [1, 'minusOne']],
                        [[40, 90], [0, 1], [0.02]],
                        [[0, 40], [-1, 0], [0.025, 'minusOne']]
                    ]
                ];

	public $time_filter_definition = 'order_close_time';
	
    protected function sum($index, $data = [])
    {
    	$datas = $this->_data;
    	if(!empty($data)) $datas = $data;

    	$sum = 0;
    	array_walk_recursive($datas, function ($val, $key) use (&$sum, $index){
    		if ($key == $index) {
    			$sum += $val;
    		}
    	});

    	return round($sum, 2);
    }

    protected function avg($index, $data = [])
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
    	return round($avg, 2);
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
    	$time = end($this->_data)[$index];

    	return ($time) ? time() - $time : 0;
    }

    //根号[∑((X-μ)^2)] ? A (A*B) X=Profit μ=Avg(∑Profit) A=Count(OrderNo(Profit>0))/Count(OrderNo)  B=Avg(Profit)
    public function variance($index, $openCapital = 1000000)
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

		$sqrt_sum = ($this->count) ? $sum / $this->count : 0;
		$variance = round(sqrt($sqrt_sum), 2);
        return $this->variance_score($variance, $openCapital);

    }

    //trading 专属方法,数据意义不明所以
    public function frequency($callback, $param)
    {
    	$denominator = call_user_func_array([$this, $callback], $param);
        $frequency = ($denominator) ? $this->count / $denominator : 0;
        $frequency = round(($frequency) * 300, 4);
        return $this->frequency_score($frequency);
    }

    //A=Count(OrderNo(Profit>0))/Count(OrderNo) 
    public function accuracy($index)
    {
    	$accuracy = ($this->count) ? $this->count_positive($index) / $this->count : 0;
    	return  round($accuracy, 4);
    }

    //(A*B) A=Count(OrderNo(Profit>0))/Count(OrderNo)  B=Avg(Profit)
    public function ability($index, $capital)
    {
    	$ability = round($this->accuracy($index) * $this->avg($index, $this->_data), 2);
        return $this->ability_score($ability, $capital);
    }

    protected function getLog($p1, $p2, $p3)
    {
        return round(log($p1 / $p3, 10), 1);
    }

    protected function minusOne($p1, $p2, $p3)
    {
        return ($p1 / $p2) - ($p3 / $p2);
    }

    protected function ability_score($ability, $capital)
    {
        $ability = $ability / $capital;
        foreach ($this->score_zone as $key => $value) {
            if ($key == 'profit_ability') {
                foreach ($value as $key) {
                   if ($ability >= $key[1][0] && $ability < $key[1][1]) {
                        if (!empty($key[2][1])) {
                            $key[0][0] += call_user_func_array([$this, $key[2][1]], [$ability, $key[2][0], $key[1][0]]);
                            $score = $key[0][0];
                        } else {
                            $key[0][0] += round($ability / $key[2][0],1);
                            $score = $key[0][0];
                        }
                   } elseif ($ability >= 500000) {
                        $score = 100;
                   } elseif ($ability < -1) {
                       $score = 0;
                   }
                }
            } 
        }
        
        return round($score, 2);
    }

    protected function variance_score($variance, $openCapital)
    {
        $variance = $variance / $openCapital;
        foreach ($this->score_zone as $key => $value) {

            if ($key == 'risk_management') {
                foreach ($value as $key) {
                   if ($variance >= $key[1][0] && $variance < $key[1][1]) {
                        if (!empty($key[2][1])) {
                            $key[0][0] -= call_user_func_array([$this, $key[2][1]], [$variance, $key[2][0], $key[1][0]]);
                            $score = $key[0][0];
                        } else {
                            $key[0][0] -= round($variance / $key[2][0],1);
                            $score = $key[0][0];
                        }
                   } elseif ($variance >= 0.71) {
                        $score = 0;
                   }
                } 
            } 
        }
        
        return round($score, 2);
    }

    protected function frequency_score($frequency)
    {
        foreach ($this->score_zone as $key => $value) {
            if ($key == 'trade_frequency') {
                foreach ($value as $key) {
                   if ($frequency >= $key[1][0] && $frequency < $key[1][1]) {
                        if (!empty($key[2][1])) {
                            $key[0][0] += call_user_func_array([$this, $key[2][1]], [$frequency, $key[2][0], $key[1][0]]);
                            $score = $key[0][0];
                        } else {
                            $key[0][0] += round($frequency / $key[2][0],1);
                            $score = $key[0][0];
                        }
                   }
                }
            } elseif ($frequency >= 100) {
                $frequency = 100;
            }
        }

        return round($score, 2);
    }

}