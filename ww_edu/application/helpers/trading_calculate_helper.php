<?php  

trait Trading_calculate  {

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
       $ability = $ability / 100000;
       print_r($ability);
    }

}