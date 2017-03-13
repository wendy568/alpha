<?php
      /*****获取taskId*****/

		/**  
      * 返回一定位数的时间戳，多少位由参数决定 
      * @param type 多少位的时间戳 
      * @return 时间戳 
      */  
     function getTimestamp($digits = false) {  
        $digits = $digits > 10 ? $digits : 10;  
        $digits = $digits - 10;  
        if ((!$digits) || ($digits == 10)){  
            return time();  
        }else{  
            return number_format(microtime(true),$digits,'','');  
        }  
     } 
	 //标识pid
   $pid=39996;
	 //任务标题
	 $title="默认任务";
	 //获取13位毫秒数
	 $timestamp=getTimestamp(13);
	 //密钥
	 $key="331943d610524ff99221f13osckreb34";
	 //组成sign
 	 $sign=md5($pid.$timestamp.$key);

	 /**
	    *接口获取参数
	    *@param1 int $pid 唯一标识
	    *@param2 char $title 任务标题
	    *@param3 int $timestamp 13位毫秒
	    *@param4 char $sign 
	    */
	 $port="http://api.emailfire.cn/api/createTask.action?pid={$pid}&title={$title}&timestamp={$timestamp}&sign={$sign}";
	 //获取参数
	 $port=file_get_contents($port);
	 //解析json
	 $port=json_decode($port,true);

	 //判断状态
	 if($port['ERROR_CODE']=='ILLEGAL_PID'){
		echo "pid不正确";
	 }elseif($port['ERROR_CODE']=="ILLEGAL_ARGUMENT"){
		echo "ddd参数不正确";exit;
	 }elseif($port['ERROR_CODE']=="LLEGAL_ANTI_PHISHING_KEY"){
		echo "非法时间戳参数";exit;
	 }elseif($port['ERROR_CODE']=='LLEGAL_SIGN'){
		echo "签名不正确";exit;
	 }elseif($port['ERROR_CODE']!='SUCCESS'){
		echo "创建任务失败";exit;
	 }
	 $taskId=$port['TASK_ID'];
	 echo $taskId;