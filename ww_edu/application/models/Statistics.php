<?php  

class Statistics extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function statistic($mem_id, $filter, $col, $year, $mon)
	{
		if ($filter == 'week') return $this->week_filter($mem_id, $col);
		if ($filter == 'month') return $this->month_filter($mem_id, $col);
		if ($filter == 'custom') return $this->custom_filter($mem_id, $col, $year, $mon);
	}

	/*
        Array
        (
        [seconds] => 45
        [minutes] => 52
        [hours] => 14
        [mday] => 24
        [wday] => 2
        [mon] => 1
        [year] => 2006
        [yday] => 23
        [weekday] => Tuesday
        [month] => January
        [0] => 1138110765
        )
     */
    /**
     * 按周过滤
     * @Author:chenqi
     * @DateTime      2016-06-07T11:51:07+0800
     * @describe      自定义传入要过滤的字段，输出一周的统计数据
     * @require       null
     * @param         int                   	$mem_id 要统计的用户id
     * @param         string                   	$col    要统计的字段
     * @return        json                      一维大括号统计数据{"5/1":1}
     */
    function week_filter($mem_id, $col)
    {
    	$date = getdate();
    	$result = array();
    	$data1 = array();
    	$data2 = array();
    	if($date['mday']<7)
    	{	
    		$prevmon = date('d', strtotime(date('Y-m-01', strtotime('now')) . ' -1 day'));
    		$last_mon = $date['mon'] - 1;
    		if ($date['mon']==1) $last_mon = 12;
    		$mon = $date['mon'].','.$last_mon;

			$map = 'SELECT `'.$col.'`  
					FROM statistic 
					WHERE mem_id="'.$mem_id.'" 
					AND year="'.$date['year'].'" 
					AND month in('.$mon.')';
			$query = $this->db->query($map);
	        $result = $query->result_array();
	        if(isset($result) && $result)
	    	{
		        foreach ($result as $key => $value) {
		        	$val = json_decode($value[$col],TRUE);
		        	for ($i=1; $i <= $date['mday']; $i++) { 
		        		if (isset($val[$date['mon'].'/'.$i]))
		        		{
		        			$data1[$date['mon'].'/'.$i] = $val[$date['mon'].'/'.$i];
		        		}
		        		elseif (!isset($data1[$date['mon'].'/'.$i])) {
		        			$data1[$date['mon'].'/'.$i] = 0;
		        		}
		        	}
		        	for ($i=$prevmon-(7-$date['mday'])+1; $i <=$prevmon; $i++) { 
		        		if (isset($val[$last_mon.'/'.$i])) 
	        			{
	        				$data2[$last_mon.'/'.$i] = $val[$last_mon.'/'.$i];
	        			}
	        			elseif (!isset($data2[$last_mon.'/'.$i])) {
	        				$data2[$last_mon.'/'.$i] = 0;
	        			}
	        			
		        	}

		        }
		        $result = array_merge(array_reverse($data1,TRUE), array_reverse($data2,TRUE));
	    	}
	    	else
	    	{
	    		for ($i=1; $i <= $date['mday']; $i++) { 

        			$data1[$date['mon'].'/'.$i] = 0;
        		}	

        		for ($i=$prevmon-(7-$date['mday'])+1; $i <=$prevmon; $i++) { 

	        		$data2[$last_mon.'/'.$i] = 0;		
		        }


		    	$result = array_merge(array_reverse($data1,TRUE), array_reverse($data2, TRUE));
	    	}
    	}
    	else
    	{
    		$map = 'SELECT `'.$col.'`  
					FROM statistic 
					WHERE mem_id="'.$mem_id.'" 
					AND year="'.$date['year'].'" 
					AND month="'.$date['mon'].'"';
			$query = $this->db->query($map);
	        $result = $query->row_array();
	        if(isset($result[$col]))
	    	{
		        foreach ($result as $key => $value) {
		        	$val = json_decode($value,TRUE);
		        	for ($i=$date['mday']-7+1; $i <= $date['mday']; $i++) { 
		        		if (isset($val[$date['mon'].'/'.$i])) {
		        			$data[$date['mon'].'/'.$i] = $val[$date['mon'].'/'.$i];
		        		}
		        		else
		        		{
		        			$data[$date['mon'].'/'.$i] = 0;
		        		}	
		        	}
	        	}
	        	$result = array_reverse($data,TRUE);
        	}
        	else
        	{
        		for ($i=$date['mday']-7+1; $i <= $date['mday']; $i++) { 

        			$data[$date['mon'].'/'.$i] = 0;
        		}	

		    	$result = array_reverse($data,TRUE);
        	}
    	}
        
        return $result;
    }
	
	function month_filter($mem_id, $col)
	{
		$date = getdate();
    	$result = array();
    	$data = array();
		$map = 'SELECT `'.$col.'`  
					FROM statistic 
					WHERE mem_id="'.$mem_id.'" 
					AND year="'.$date['year'].'" 
					AND month="'.$date['mon'].'"';
		$query = $this->db->query($map);
        $result = $query->row_array();
	    if(isset($result[$col]))
	    {
	    	foreach ($result as $key => $value) {
		    	$val = json_decode($value,TRUE);
		    	for ($i=1; $i <= $date['mday']; $i++) { 
		    		if (isset($val[$date['mon'].'/'.$i])) {
	        			$data[$date['mon'].'/'.$i] = $val[$date['mon'].'/'.$i];
	        		}
	        		else
	        		{
	        			$data[$date['mon'].'/'.$i] = 0;
	        		}	
		    	}

		    	$result = array_reverse($data,TRUE);
		    }
	    }
	    else
	    {
	    	for ($i=1; $i <= $date['mday']; $i++) { 

        			$data[$date['mon'].'/'.$i] = 0;
        		}	

	    	$result = array_reverse($data,TRUE);
	    }
	    
	    return $result;
	}

	function custom_filter($mem_id, $col, $year, $mon)
	{
		$date = date('d', strtotime(date('Y-m-01', strtotime("{$year}-{$mon}")) . ' +1 month -1 day'));
    	$result = array();
    	$data = array();
		$map = 'SELECT `'.$col.'`  
					FROM statistic 
					WHERE mem_id="'.$mem_id.'" 
					AND year="'.$year.'" 
					AND month="'.$mon.'"';
			$query = $this->db->query($map);
	        $result = $query->row_array();
        if(isset($result[$col]))
        {
        	foreach ($result as $key => $value) {
		    	$val = json_decode($value,TRUE);
		    	for ($i=1; $i <= $date; $i++) { 
		    		if (isset($val[$mon.'/'.$i])) {
	        			$data[$mon.'/'.$i] = $val[$mon.'/'.$i];
	        		}
	        		else
	        		{
	        			$data[$mon.'/'.$i] = 0;
	        		}	
		    	}
		    	$result = array_reverse($data,TRUE);
	    	}
        }
        else
        {
        	for ($i=1; $i <= $date; $i++) { 
        			$data[$mon.'/'.$i] = 0;
        		}	
	    	
	    	$result = array_reverse($data,TRUE);
        }
	    
	    return $result;
	}


}