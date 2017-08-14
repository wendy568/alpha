<?php
	/****发送邮件****/

class send_user
{
     //密钥
    private  $key="331943d610524ff99221f13osckreb34";

    private  $postdata=Array(
		'pid' => 39996,
		'title' => 'AlphaTader',
		'taskId' => '693788',
		'replay' => 'info@wecapital.com',
		'displayName' => 'AlphaTader',
		'fromEmail' => 'info@notice.wecapital.com',
		'content' => '如果您收到此内容，有可能您的帐号登陆已失效或者临时下线，请重新登陆，在发送此邮件，谢谢',
		'recipient' => 'chenqidage@vip.qq.com',
		'timestamp' => '',
		'sign' => ''
	);

	public static function build() {
        return new send_user();
       
    }

	public function __get($name){
        if(isset($this->postdata[$name])) {
            return $this->postdata[$name];
        }
        return null;
    }

    public function __set($name,$value){
        if(isset($this->postdata[$name])) {
            $this->postdata[$name] = $value;
        }
    }

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

	//构建post函数提交内容,POST方式
     function post($url, $data){ 
        $postdata = http_build_query( 
            $data 
        );
        $opts = array('http' => 
                      array( 
                          'method'  => 'POST', 
                          'header'  => 'Content-type: application/x-www-form-urlencoded', 
                          'content' => $postdata 
                      ) 
        ); 
        $context = stream_context_create($opts); 
        $result = file_get_contents($url, false, $context); 
        return $result;  
    }

	
	//获取13位毫秒数
	 function timestamp()
	{
		return $this->getTimestamp(13);
	}
	
	 function emailsign()
	{
		return md5($this->postdata['pid'].$this->postdata['taskId'].$this->timestamp().$this->key);
	} 

	/**
	   *执行发送邮件操作
	   *@param1 int $pid 唯一标识
	   *@param2 char $title 任务标题
	   *@param3 int $taskId 任务编号
	   *@param4 char $replay 邮件回复地址（可选）
	   *@param5 char $displayName 发件人（可选）
	   *@param6 char $fromEmail	发件人邮箱
	   *@param7 char $recipient 收件人邮箱
	   *@param8 int $timestamp 13位毫秒
	   *@param9 char $emailsign 邮件sign
	   */
	
	 function send(&$response)
	{
		//Eamilfire接口地址
		$url="http://api.emailfire.cn/api/sendMail.action";

		$send=$this->post($url, $this->postdata);
		//print_r($send);
		//解析json
		$send=json_decode($send,true);
		//判断状态
		if($send['ERROR_CODE']=='ILLEGAL_ARGUMENT'){
			$response = array('archive' => array('status' => 12,'message' => "参数不正确"));
		}elseif($send['ERROR_CODE']=='ILLEGAL_REPLAY'){
			$response = array('archive' => array('status' => 8,'message' => "回复邮箱无效"));
		}elseif($send['ERROR_CODE']=='ILLEGAL_RECIPIENT'){
			$response = array('archive' => array('status' => 2,'message' => "收件人邮箱无效"));
		}elseif($send['ERROR_CODE']=='ILLEGAL_FROM_MAIL'){
			$response = array('archive' => array('status' => 3,'message' => "发件人邮箱无效"));
		}elseif($send['ERROR_CODE']=='LLEGAL_ANTI_PHISHING_KEY'){
			$response = array('archive' => array('status' => 4,'message' => "非法时间戳参数"));
		}elseif($send['ERROR_CODE']=='ILLEGAL_PID'){
			$response = array('archive' => array('status' => 5,'message' => "pid无效"));
		}elseif($send['ERROR_CODE']=='LLEGAL_ZERO'){
			$response = array('archive' => array('status' => 6,'message' => "API 投递量不足"));
		}elseif($send['ERROR_CODE']=='LLEGAL_SIGN'){
			$response = array('archive' => array('status' => 7,'message' => "签名不正确"));
		}elseif($send['ERROR_CODE']=='SUCCESS'){
			$response = array('archive' => array('status' => 0,'message' => "邮件发送成功"));
		}
	}
	
}

?>