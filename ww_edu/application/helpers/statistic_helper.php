<?php  
class custom
{

	public static function build()
	{
		return new custom();
	}

	/**
     * 统计
     * @Author:chenqi
     * @DateTime      2016-05-18T15:19:32+0800
     * @describe      按月统计(数据库一行)
     * @require       null
     * @param         int                       $mem_id  用户ID
     * @param         decimal                   $content 增加的数量
     * @param         char                      $col     统计的字段
     * @return        bool                      $result  存储成功
     */
    
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
	function statistic($mem_id,$content,$col)
	{
		$ci = & get_instance();
	    $result = array();
	    $date = getdate();
	    //拼装一维数组：统计格式｛日期：数量...｝
	    $statistic[$date['mon'].'/'.$date['mday']] = $content;
	    //查看当年当月统计数据
	    $map = 'SELECT *  
	            FROM statistic
	            WHERE mem_id="'.$mem_id.'" and month="'.$date['mon'].'" and year='.$date['year'];
	    
	    $query = $ci->db->query($map);
	    $result = $query->row_array();
	    //判断该用户当年当月是否已经开始统计
	    if (isset($result['id']))
	    {
	        //判断某一字段（某种统计）是否已经统计
	        if (isset($result[$col])) {
	            $data = array();
	            //取出该字段的统计数据，解析成数组（一维），并覆盖之前拼装的统计数据
	            $statistic = json_decode($result[$col],TRUE);
	            //重新拼装统计数据
	            $data[$date['mon'].'/'.$date['mday']] = $content;
	            //判断已统计的字段在当前日期（几月几日）是否有统计数据
	            if (isset($statistic[$date['mon'].'/'.$date['mday']])) {
	                //更新当前日期的统计数据

	                $statistic[$date['mon'].'/'.$date['mday']] = $statistic[$date['mon'].'/'.$date['mday']] + $content;
	            }
	            else
	            {
	                //新拼装的统计数据合并已统计的，更新到当前日期
	                $statistic = array_merge($statistic, $data);
	            }

	            //更新该字段的统计数据到数据库
	            $map = 'UPDATE statistic 
	                   SET `'.$col.'`="'.addslashes(json_encode($statistic)).'" 
	                   WHERE mem_id="'.$mem_id.'" and month="'.$date['mon'].'" and year='.$date['year'];
	           
	            $query = $ci->db->query($map);
	        }
	        //如果某字段没有统计，直接更新之前拼装的统计数据到该字段下
	        else
	        {
	            $map = 'UPDATE statistic 
	                   SET `'.$col.'`="'.addslashes(json_encode($statistic)).'" 
	                   WHERE mem_id="'.$mem_id.'" and month="'.$date['mon'].'" and year='.$date['year'];
	           
	            $query = $ci->db->query($map);
	        }
	        
	    }
	    //如果该用户在当年当月没有统计数据，直接把之前拼装的统计数据插入数据库
	    else
	    {
	        $map = 'INSERT statistic(year,month,mem_id,`'.$col.'`) VALUES("'.$date['year'].'","'.$date['mon'].'","'.$mem_id.'","'.addslashes(json_encode($statistic)).'")';
	        $query = $ci->db->query($map);
	        $result = $ci->db->insert_id();
	    }
	        
	    return $result;

	}
}
