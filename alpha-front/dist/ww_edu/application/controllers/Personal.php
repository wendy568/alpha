<?php

class Personal extends MY_Controller
{
	// public function info()
	// {
	// 	header( 'Access-Control-Allow-Origin:*' );
	// 	$token = $this->input->get_post('token', TRUE);
	// 	$this->load->database();
	// 	$this->load->helper('json');
	// 	$this->load->model('user_info');
	// 	$data = $this->user_info->info($token);
	// 	$response = array('archive' => array('status' => 0,'message' =>''));
	// 	encode_json($response,$data);
	// }

	public function get_bytoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken($token);
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

	public function email_isexists()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$email = $this->input->get_post('email', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['is_exists'] = $this->login->email_isexists($email);

		encode_json($response,$data);
	}

	public function captcha()
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('personals');
		$this->load->library('validatecode');
		$this->validatecode->doimg();
		$this->personals->save($this->validatecode->getCode(), $this->input->ip_address());
	}

	public function code()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['code'] = $this->personals->get_code($this->input->ip_address());
	
		encode_json($response,$data);
	}

	public function inner_mail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$id = $this->get_bytoken($token);
		$is_read = $this->input->get_post('is_read', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->personals->show_mail($id, $is_read, $data);
	
		encode_json($response,$data);
	}

	public function mail_count()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$id = $this->get_bytoken($token);
		$is_read = $this->input->get_post('is_read', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->personals->mail_count($id, $is_read);
	
		encode_json($response,$data);
	}

	public function isexists_inner_mail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
		
		$data['data'] = array();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->personals->isexists_inner_mail($id, $data);
	
		encode_json($response,$data);
	}

	public function is_read()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$mail_id = $this->input->get_post('mail_id', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['is_read'] = $this->personals->is_read($mail_id);
	
		encode_json($response,$data);
	}

	public function follow_mem()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->input->get_post('mem_id', TRUE);
		$from_id = $this->get_bytoken($token);
		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('statistic');
		$stas = custom::build();
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['is_follow'] = $this->personals->follow_mem($mem_id, $from_id, $response, $stas);
	
		encode_json($response,$data);
	}

	public function is_follow()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->input->get_post('mem_id', TRUE);
		$from_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['is_follow'] = $this->personals->is_follow($mem_id, $from_id);
	
		encode_json($response,$data);
	}

	public function follow_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->personals->follow_list($mem_id);
	
		encode_json($response,$data);
	}

	public function follow_list_other()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$mem_id = $this->input->get_post('mem_id', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->personals->follow_list_other($mem_id);
	
		encode_json($response,$data);
	}

	public function email_for_password()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$email = $this->input->get_post('email', TRUE);
		$this->load->database();
		$this->load->model('personals');
		$this->load->helper('constants');
		$const = constants::build();
		
		$title = 'Alpha Trader 修改密码信息';
		$str = $this->encode($email);
		$time = $this->encode(strtotime('+ 1 day'));
		$file = file_get_contents(ALPHATEXT.'forget.html');
		$query = array(
				'referer' => $str,
				'verify' => $time
			);
		$list = array(
				'replaceUrl' => $const->alphatrader['base']['_pwd_site'].'?'.http_build_query($query)
			);
		array_walk($list, function ($item, $key) use (&$file){
			$file = str_replace($key, $item, $file);
		});

		$data['data'] = array();
		$response = array('archive' => array('status' => 0,'message' =>''));
		
		$this->load->helper('json');

		$query = $this->request_post('http://alphacoin.co.uk/mail.php',array(
			'title' => $title,
			'content' => $file,
			'email' => $email,
			'ssl' => $const->alphatrader['base']['ssl'],
		));
		encode_json($response, $data);
	}

	public function change_password()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$new_passwd = $this->input->get_post('new_passwd', TRUE);
		$exists = ($new_passwd)?TRUE:FALSE;
		$referer = $this->input->get_post('referer', TRUE);
		$verify = $this->input->get_post('verify', TRUE);
		$str = $this->decode($referer);
		$verify = $this->decode($verify);
		if(!$exists) exit(json_encode($response = array('archive' => array('status' => 401,'message' =>'请重新输入'))));

		if($verify < time()) exit(json_encode($response = array('archive' => array('status' => 701,'message' =>'该页面已经失效，请重新发送邮件!'))));
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('login');
		
		$data = array();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->login->change_password($new_passwd, $str, $response, $data);
	
		encode_json($response,$data);
	}

	public function email_verify()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$referer = $this->input->get_post('referer', TRUE);
		$verify = $this->input->get_post('verify', TRUE);
		$str = $this->decode($referer);
		$verify = $this->decode($verify);
		if($verify < time()) exit(json_encode($response = array('archive' => array('status' => 701,'message' =>'该页面已经失效，请重新发送邮件!'))));
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('users');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->users->email_verify($str);
	
		encode_json($response,$data);
	}

	public function statistic()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$year = $this->input->get_post('year', TRUE);
		$mon = $this->input->get_post('mon', TRUE);
		$col = $this->input->get_post('col', TRUE);
		$filter = $this->input->get_post('filter', TRUE);
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('statistics');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['statistics'] = $this->statistics->statistic($mem_id,$filter, $col, $year, $mon);
		encode_json($response,$data);
	}

	public function numbers()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('statistics');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->statistics->numbers($mem_id);
	
		encode_json($response,$data);
	}

	public function like()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		$dis_id = $this->input->get_post('dis_id', TRUE);
		$like = $this->input->get_post('like', TRUE);
		$from_id = $this->input->get_post('from_id', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('statistic');
		$this->load->model('personals');

		$stas = custom::build();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->personals->like($mem_id, $dis_id, $like, $from_id, $response, $stas);
	
		encode_json($response,$data);
	}

	public function is_like()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		$dis_id = $this->input->get_post('dis_id', TRUE);
		$like = $this->input->get_post('like', TRUE);
		$dis_id = implode(',',explode('@', $dis_id));

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->personals->is_like($mem_id, $dis_id, $like);
	
		encode_json($response,$data);
	}

	public function sum_person()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);		
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->personals->sum_person($mem_id);
	
		encode_json($response,$data);
	}

	public function image_cut()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);

		$file_name = $this->input->get_post('file_name', TRUE);
		$dir_name = $this->input->get_post('dir_name', TRUE);
		$new_width = $this->input->get_post('new_width', TRUE);
		$new_height = $this->input->get_post('new_height', TRUE);
		$x = $this->input->get_post('x', TRUE);
		$y = $this->input->get_post('y', TRUE);
		$ratio = $this->input->get_post('ratio', TRUE);
		
		$this->load->database();
		$this->load->helper('set_source');
		$this->load->helper('json');
		$this->load->model('personals');

		$face = '';
		$response = array('archive' => array('status' => 0,'message' =>'success'));
		$data['data'] = array();

		$bool = cut_image($file_name, $dir_name, $new_width, $new_height, $x, $y, $ratio, $face, $response, $data);

		if ($bool !== FALSE) {
			$this->personals->update_face($mem_id, $face, $response, $data);
		}
		
		encode_json($response,$data);
	}

	public function test()
	{
		$this->load->database();
		$this->load->model('TradingAnalysis');
		$this->TradingAnalysis->export_mt4_datas();
		$this->load->library('Trading_datas_calculate');
		$this->Trading_datas_calculate->import_datas = '123';
		die;
		$file = $this->input->get_post('file', TRUE);

		$mt4_format = array(
				'order_no',
				'account_number',
				'order_symbol',
				'order_type',
				'order_lots',
				'order_open_price',
				'order_open_time',
				'order_close_price',
				'order_close_time',
				'order_take_profit',
				'order_stop_loss',
				'profit'
			);	
		$datas = [];
		if (($handle = fopen(getcwd()."/{$file}.csv", "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 0, "|")) !== FALSE) {
		    	static $i=0;
		    	array_walk($data, function ($val, $key) use ($mt4_format, &$datas, $i) {
		    		if(isset($val)) $datas[$i][$mt4_format[$key]] = $val;	
		    	});
		    	// $datas[] = array_combine($mt4_format, $data);
		    	$i++;
		    }
		    fclose($handle);
		}

		$this->load->helper('databases_filter');
		$this->load->database();
		$this->load->model('admins');

		$dfdb = databases_filter::build();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$cols = array('mt4_export_datas');
		foreach ($datas as $value) {
			$dfdb->set_query($cols, $value)
			     ->filter_blank($cols)
				 ->insert_complete($cols);
			
			$this->admins->add($cols, $response);
			$cols = array('mt4_export_datas');
		}
		die;
		// $this->load->model('personals');
		// ob_start();
		// ob_clean();
		// for ($i=10; $i>0; $i--)
		// {
		//     echo $i;
		//     ob_flush();//修改部分
		//     flush();
		//     sleep(1);
		// }
		// $data = $_FILES['file'];
		// move_uploaded_file($data['tmp_name'], './upload/data.csv');
		// $file = fopen('./upload/data.csv', 'r');
		// while(($csv = fgetcsv($file, 0, '|'))!==FALSE)
		// {
		// 	echo $this->personals->test($csv[0],$csv[1],addslashes($csv[2]),$csv[3]);
		// }
		// $data = $this->personals->test();
		// $a = exec("ffmpeg output ");
		// foreach ($data as $key => $value) {
		// 	fopen('/u', mode)
		// }
		
		// $this->request_post('http://alphacoin.co.uk/mail.php',array(
		// 		'title' => '哥哥胖',
		// 		'content' => file_get_contents(ALPHATEXT.'verify.html'),
		// 		'email' => 'chenqidage@vip.qq.com',
		// 		'ssl' => parse_ini_file(INI.'alphatrader.ini',TRUE)['base']['ssl'],
		// 	));
		
// 		function benchmark_function($fn,$args=null)
	// {
	//     if(!function_exists($fn))
	//     {
	//         trigger_error("Call to undefined function $fn()",E_USER_ERROR);
	//     }

	//     $t = microtime(true);

	//     $r = call_user_func_array($fn,$args);

	//     return array("time"=>(microtime(true)-$t),"returned"=>$r,"fn"=>$fn);
	// }

	// function get_len_loop($s)
	// {
	//     while($s[$i++]){}
	//     return $i-1;
	// }
	// echo var_dump(benchmark_function("strlen","kejhkhfkewkfhkwjfjrw"))."<br>";
	// echo var_dump(benchmark_function("get_len_loop","kejhkhfkewkfhkwjfjrw"));

	// $p = new PharData(dirname(__FILE__).'/bar.zip', 0,'phartest',Phar::ZIP); 
	// $p->addFromString('test.txt', 'this is just some test text'); 
	// echo file_get_contents('phar://'.dirname(__FILE__).'/bar.zip/test.txt'); 


		// $this->load->database();
		// $this->load->helper('pagination');
		// $this->load->model('discussions');
		// // $data['data'] = $this->discussions->test();
		// echo  json_encode($this->discussions->test());
		// // system("echo {$data} > /Users/pro/www/data.json"); 

		// $this->load->helper('solr');
		// $solr = solr::build();
		// print_r($solr->add_update());
		// print_r($solr->delete());
		// $options = array('hostname' => 'localhost', 'port' => '8983', 'path' => '/solr/videos'); 
		// echo $this->get_byadmintoken('$2y$10$/Mbk48dgP/EytWLmb9cad.JJacIwrGe3y7.Mo7r7ftYER6T1E/Idm');
	}

}
















