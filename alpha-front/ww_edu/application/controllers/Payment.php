<?php

use Alipay\AlipaySubmit;

class Payment extends MY_Controller
{
	public function alipay()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$this->load->helper('constants');
		$const = constants::build();

		$alipay_config = $const->alphatrader['alipay'];
		$alipay_config['sign_type'] = strtoupper('MD5');
		$alipay_config['input_charset'] = strtolower('utf-8');
		$alipay_config['cacert'] = getcwd().'/cacert.pem';


        //商户订单号，商户网站订单系统中唯一订单号，必填
		$out_trade_no = $this->input->get_post('WIDout_trade_no', TRUE);
		//订单名称，必填
		$subject = $this->input->get_post('WIDsubject', TRUE);
		//付款外币币种，必填
		$currency = $this->input->get_post('currency', TRUE);
		//付款外币金额，必填
		$total_fee = $this->input->get_post('WIDtotal_fee', TRUE);
		//商品描述，可空
		$body = $this->input->get_post('WIDbody', TRUE);

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service"       => $alipay_config['service'],
				"partner"       => $alipay_config['partner'],
				"notify_url"	=> $alipay_config['notify_url'],
				"return_url"	=> $alipay_config['return_url'],
				
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"currency" => $currency,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
				//其他业务参数根据在线开发文档，添加参数.文档地址:https://ds.alipay.com/fd-ij9mtflt/home.html
		        //如"参数名"=>"参数值"
		);
	
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
}