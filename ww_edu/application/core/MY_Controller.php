<?php
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->library('session');
		//session_start();
		//$this->origin = $this->get_origin();
	}

	public function get_bytoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken($token);
		return $data;
	}

	public function get_trading_account($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_trading_account($token);
		return $data;
	}

	public function get_bytoken_id_forAdmin($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('admins');
		$data = $this->admins->get_bytoken_id($token);
		return $data;
	}

	public function get_bytoken_id($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken_id($token);
		return $data;
	}

	public function get_byadmintoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('admins');
		$data = $this->admins->get_bytoken($token);
		return $data;
	}

	public function _exit($sys_code, $user_code, $text)
	{
		header("Content-type: application/json");
		set_status_header($sys_code);
		echo json_encode($response = array('archive' => array('status' => $user_code,'message' => $text)));
		exit(EXIT__AUTO_MIN);
	}

	/**
	 * 简单对称加密算法之加密
	 * @param String $string 需要加密的字串
	 * @param String $skey 加密EKY
	 * @author Anyon Zou <zoujingli@qq.com>
	 * @date 2013-08-13 19:30
	 * @update 2014-10-10 10:10
	 * @return String
	 */
	function encode($string = '', $skey = 'chenqi') {
	    $strArr = str_split(base64_encode($string));
	    $strCount = count($strArr);
	    foreach (str_split($skey) as $key => $value)
	        $key < $strCount && $strArr[$key].=$value;
	    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
	}
	/**
	 * 简单对称加密算法之解密
	 * @param String $string 需要解密的字串
	 * @param String $skey 解密KEY
	 * @author Anyon Zou <zoujingli@qq.com>
	 * @date 2013-08-13 19:30
	 * @update 2014-10-10 10:10
	 * @return String
	 */
	function decode($string = '', $skey = 'chenqi') {
	    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
	    $strCount = count($strArr);
	    foreach (str_split($skey) as $key => $value)
	        $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
	    return base64_decode(join('', $strArr));
	}

	public function get_origin()
	{
		$ip = $this->input->ip_address();
		$arr = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
		$arr = json_decode($arr,true);
		return $arr;
	}

	public function email($email, $title, $content)
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$this->load->database();
		$this->load->model('personals');

		$response = array('archive' => array('status' => 0,'message' =>''));
		
		$this->load->helper('mail');
		$send = send_user::build();
		$send->title = $title;
		$send->timestamp = $send->timestamp();
        $send->sign = $send->emailsign();
        $send->recipient = $email;
        $send->content = $content;
		$send->send($response);
		// print_r($response);die;
	}

	public function postSend($mobile) 
	{
		$send_content .= "【琪哥哥】";
		$send_content = iconv("utf-8", "gbk", $send_content);//这里需要转换成gbk
		$postUrl = sprintf( "http://221.122.112.136:8080/sms/mt.jsp?cpName=kuaishifu&cpPwd=123456&phones=%s&spCode=%s&msg=%s&extNum=0" , $mobile, time(), urlencode($send_content));
		$file = file_get_contents($postUrl);
		if($file==0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function request_get($url)
	{
		$response = array('archive' => array('status' => 0,'message' =>''));
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
		$output = curl_exec($ch) ; 
		return $output;
	}

   function request_post($url = '', $post_data = array()) 
   {
		if (empty($url) || empty($post_data)) 
		{
		    return false;
		}

		$o = "";
		foreach ( $post_data as $k => $v ) 
		{ 
		    $o.= "$k=" . urlencode( $v ). "&" ;
		}
		$post_data = substr($o,0,-1);

		$postUrl = $url;
        $curlPost = $post_data;
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = curl_exec($ch);//运行curl
		// $data = json_decode($data,true);
		curl_close($ch);

		return $data;
    }

	public function get_time()
	{
		list($micro,$time) = explode(' ',microtime());
		$time = floatval($micro)+floatval($time);
		return $time;
	}

	public function start_time()
	{
		return $start = $this->get_time();
	}

	public function end_time()
	{
		return $end = $this->get_time();
	}

	public function jquery_alert($message)
	{
		echo '<script>alert("'.$message.'");</script>';
	}

	public function jquery_href($href)
	{
		echo '<script>window.location.href="'.$href.'";</script>';
	}

	public function jquery_go($go)
	{
		echo '<script>window.history.go("'.$go.'");</script>';
	}

	public function jquery_sleep($go)
	{
		echo '<script>setTimeout(function () {
            window.location = "'.$go.'"
        },500)</script>';
	}

}