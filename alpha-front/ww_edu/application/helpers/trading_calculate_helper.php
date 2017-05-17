<?php  

trait Trading_calculate  {

    protected $score_zone = [
                    'risk_management' => [
                        [[90, 100], [0, 0.001], [0.0001]],
                        [[60, 90], [0.001, 0.01], [0.0005]],
                        [[10, 60], [0.01, 0.21], [0.004]],
                        [[0, 10], [0.21, '>'], [0.05]]
                    ],
                    'trade_frequency' => [
                        [[0, 10], [0, 0.0001], [0.00001]],
                        [[10, 25], [0.0001, 0.001], [0.00006]],
                        [[25, 40], [0.001, 0.01], [0.0006]],
                        [[40, 55], [0.01, 0.1], [0.006]],
                        [[55, 70], [0.1, 1], [0.06]],
                        [[70, 85], [1, 10], [0.6]],
                        [[85, 100], [10, 100], [6]]
                    ],
                    'profit_ability' => [
                        [[95, 100], [5, 500000], [10, 'log']],
                        [[90, 95], [1, 5], [1]],
                        [[40, 90], [0, 1], [0.02]],
                        [[0, 40], [-1, 0], [0.025]]
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
    	$time = current($this->_data)[$index];
    	return ($time) ? time() - $time : 0;
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

		$sqrt_sum = ($this->count) ? $sum / $this->count : 0;
		return round(sqrt($sqrt_sum), 2);

    }

    //trading 专属方法,数据意义不明所以
    public function frequency($callback, $param)
    {
    	$denominator = call_user_func_array([$this, $callback], $param);
    	$frequency = ($denominator) ? $this->count / $denominator : 0;
    	return round(($frequency) * 300, 4);
    }

    //A=Count(OrderNo(Profit>0))/Count(OrderNo) 
    public function accuracy($index)
    {
    	$accuracy = ($this->count) ? $this->count_positive($index) / $this->count : 0;
    	return  round($accuracy, 2);
    }

    //(A*B) A=Count(OrderNo(Profit>0))/Count(OrderNo)  B=Avg(Profit)
    public function ability($index)
    {   $ability = round($this->accuracy($index) * $this->avg($index, $this->_data), 2);
        $this->ability_score($ability);
    	return $ability;
    }

    protected function ability_score($ability)
    {
        foreach ($this->score_zone as $key => $value) {
            if ($key == 'profit_ability') {
                foreach ($value[0] as $key) {
                    print_r($key);
                }
            }
        }
       // $ability = $ability / 5000;
       // $ability / 
       // print_r($ability);
    }

}