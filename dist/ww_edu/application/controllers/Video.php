<?php
use Blablacar\Memcached\Client;

class Video extends MY_Controller
{
	public function get_bytoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken($token);
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

	public function list()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		$cat_id = $this->input->get_post('cat_id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
		$this->load->helper('return_time');
		$time = return_time::build();

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->list($limit, $time, $start, $cat_id);
	
		encode_json($response,$data);
	}

	public function videos_search()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		// $this->load->helper('constants');
		$this->load->helper('solr');
		$solr = solr::build();
		// $const = constants::build();
		$q = $this->input->get_post('q', TRUE)?$this->input->get_post('q', TRUE):'*:*';
		$start = $this->input->get_post('start', TRUE)?$this->input->get_post('start', TRUE):0;
		$limit = $this->input->get_post('limit', TRUE)?$this->input->get_post('limit', TRUE):5;
		// $q = urlencode($q);
		echo $solr->getQuery($q, $start, $limit);
		// $url = $const->alphatrader['base']['base_site'] . ":8983/solr/videos/select?indent=on&q={$q}&wt=json";
		// echo $this->request_get($url);
	}

	public function has_connect_search()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->helper('constants');
		// $const = constants::build();
		$this->load->helper('solr');
		$solr = solr::build();
		$q = $this->input->get_post('q', TRUE)?$this->input->get_post('q', TRUE):'*:*';
		$start = $this->input->get_post('start', TRUE)?$this->input->get_post('start', TRUE):0;
		$limit = $this->input->get_post('limit', TRUE)?$this->input->get_post('limit', TRUE):5;
		// $q = urlencode($q);
		// $url = $const->alphatrader['base']['base_site'] . ":8983/solr/videos/select?indent=on&q={$q}&wt=json";
		try{
			$solr->getQuery($q, $start, $limit);
			//echo $this->request_get($url);
		}catch(Exception $e){
			echo json_encode(array('archive' => array('status' => 3002,'message' => 'something wrong with searching engine datas import')));
			exit();
		}
	}

	public function videos_detail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$class_id = $this->input->get_post('class_id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
		$this->load->helper('return_time');
		$time = return_time::build();
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->videos_detail($class_id, $time);
	
		encode_json($response,$data);
	}

	public function like()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$class_id = $this->input->get_post('class_id', TRUE);
		$mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->videos->like($mem_id, $class_id);
	
		encode_json($response,$data);
	}

	public function follow_video()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$class_id = $this->input->get_post('class_id', TRUE);
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->videos->follow_video($mem_id, $class_id);
	
		encode_json($response,$data);
	}

	public function is_like_follow()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$class_id = $this->input->get_post('class_id', TRUE);
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->is_like_follow($mem_id, $class_id);
	
		encode_json($response,$data);
	}

	public function message_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$class_id = $this->input->get_post('class_id', TRUE);
		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		$mem_id = $this->get_bytoken_id($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
		$this->load->helper('return_time');
		$time = return_time::build();

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->message_list($class_id, $time, $limit, $start, $mem_id);
	
		encode_json($response,$data);
	}

	public function reply_message_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$class_id = $this->input->get_post('class_id', TRUE);
		$mess_id = $this->input->get_post('mess_id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
		$this->load->helper('return_time');
		$time = return_time::build();

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->reply_message_list($class_id, $mess_id, $time);
	
		encode_json($response,$data);
	}

	public function is_reply($mem_id, $from_id)
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		// $token = $this->input->get_post('token', TRUE);
		// $mem_id = $this->get_bytoken($token);
		// $from_id = $this->input->get_post('from_id', TRUE);
		if ($mem_id == $from_id)
		{
			// $response = array('archive' => array('status' => 0,'message' =>'success'));
		} else {
			$response = array('archive' => array('status' => 2003,'message' =>'fail'));
			$data['data'] = array();
			exit(json_encode(array_merge($response,$data)));
		}	
	}

	public function reply_message()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$class_id = $this->input->get_post('class_id', TRUE);
		$mem_id = $this->get_bytoken($token);
		$mess_id = $this->input->get_post('mess_id', TRUE);
		$from_id = $this->input->get_post('from_id', TRUE);
		$content = $this->input->get_post('content', TRUE);
		$class_from_id = $this->input->get_post('class_from_id', TRUE);
		$this->is_reply($mem_id, $class_from_id);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->videos->reply_message($mem_id, $from_id, $class_id, $mess_id, $content);
	
		encode_json($response,$data);
	}

	public function reply_message_me()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$class_id = $this->input->get_post('class_id', TRUE);
		$mem_id = $this->get_bytoken($token);
		$mess_id = $this->input->get_post('mess_id', TRUE);
		$from_id = $this->input->get_post('from_id', TRUE);
		$content = $this->input->get_post('content', TRUE);
		// $class_from_id = $this->input->get_post('class_from_id', TRUE);
		// $this->is_reply($mem_id, $class_from_id);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->videos->reply_message($mem_id, $from_id, $class_id, $mess_id, $content);
	
		encode_json($response,$data);
	}

	public function click_views($class_id)
	{
		// header( 'Access-Control-Allow-Origin:*' );
	
		// $token = $this->input->get_post('token', TRUE);
		// $class_id = $this->input->get_post('class_id', TRUE);
		// $mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		// $response = array('archive' => array('status' => 0,'message' =>''));
		// $data['data'] = array();
		$this->videos->click_views($class_id);
	
		// encode_json($response,$data);
	}

	public function event()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->event();
	
		encode_json($response,$data);
	}

	public function live_on_now()
	{
		header( 'Access-Control-Allow-Origin:*' );
			
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->live_on_now();
	
		encode_json($response,$data);
	}

	public function upload_video()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$this->get_byadmintoken($token);
		$datas['from_id'] = $this->get_bytoken_id_forAdmin($token);
		$this->has_connect_search();
		$datas['create_time'] = date('Y-m-d H:i:s', time());
		$datas['update_time'] = date('Y-m-d H:i:s', time());
		if(!empty($datas['name'])) $datas['name'] = addslashes($datas['name']);
		if(!empty($datas['describe'])) $datas['describe'] = addslashes($datas['describe']);
		// $cha = mb_detect_encoding($datas['name']);
	
		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$this->load->helper('solr');
		$solr = solr::build();

		$image = get_image(160, 90, 'videos');

		if($image) $datas['image'] = addslashes(json_encode(array('videos/'.json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));
		$dfdb = databases_filter::build();
		$cols = array('classes_online');

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->insert_complete($cols);
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('videos');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data = array();
		$this->videos->insert_video_info($cols, $response, $solr, $data);

		encode_json($response, $data);
	}

	public function update_video()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$datas = $this->input->post();
		$this->get_byadmintoken($token);
		$this->has_connect_search();
		$datas['update_time'] = date('Y-m-d H:i:s', time());
		$datas['name'] = addslashes($datas['name']);
		$datas['describe'] = addslashes($datas['describe']);
		// $cha = mb_detect_encoding($datas['name']);
	
		$this->load->helper('json');
		$this->load->helper('databases_filter');
		$this->load->helper('set_source');
		$this->load->helper('solr');
		$solr = solr::build();

		$image = get_image(160, 90, 'videos');

		if($image)$datas['image'] = addslashes(json_encode(array('videos/'.json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));
		$dfdb = databases_filter::build();
		$cols = array('classes_online');

		$dfdb->set_query($cols, $datas)
		     ->filter_blank($cols)
			 ->update_complete($cols, array('classes_online'=>array('id'=>$datas['id'])));
		// print_r($cols);die;
		$this->load->database();
		$this->load->model('videos');
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->update_video_info($cols, $response, $solr, $datas['id']);

		encode_json($response, $data);
	}

	public function delete_video()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$source = $this->input->get_post('source', TRUE);
		$id = $this->input->get_post('id', TRUE);
		$this->get_byadmintoken($token);

		$this->load->database();
		$this->load->model('videos');
		$this->load->helper('botrapi');
		$this->load->helper('solr');
		$this->load->helper('json');
		$solr = solr::build();
		$botr_api = new BotrAPI('c6PABMlh', 'CLJeFvRzMIyA4bsB4SV5eZlH');
		$response = $botr_api->call('/videos/delete', array('video_key'=>$source));
		$response = (!empty($response)) ? $response : array('videos' => '');
		$data = array();
		if($response['videos'][$source] == 'deleted')
		{
			try{
				$solr->delete($id);
			}catch (Exception $e) {
    			echo json_encode(array('archive' => array('status' => 3002,'message' => $e->getMessage())));
    			exit();
			}
			
			$this->videos->delete_video($source, $id, $response);
			
		}elseif($response['videos'][$source] == 'not-found'){
			$this->videos->delete_video_else($id);
			$solr->delete($id);
			$response = array('archive' => array('status' => 3001,'message' =>'删除失败，该视频播放源不存在，由于播放源不存在，该条记录属于冗余数据，系统将自动清理该数据'));
		}else{
			$response = array('archive' => array('status' => 3004,'message' =>'删除失败，请检查[VPN]或者[网络连接]是否有问题'));
		}
		encode_json($response,$data);
	}

	public function views_history()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$date_limit = $this->input->get_post('date_limit', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
		$this->load->helper('return_time');
		$this->load->helper('time_zone');
		$time = return_time::build();
		// $ads = time_zone::build();
		// print_r(date('Y-m-d H:i:s', $ads->lastDayInMonthOfBegin()->get_time_zone()));
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->views_history($mem_id, $time, time_zone::build(), $date_limit);
	
		encode_json($response,$data);
	}

	public function views_history_mark()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$class_id = $this->input->get_post('class_id', TRUE);
		$this->click_views($class_id);
		$token = $this->input->get_post('token', TRUE);
		if(!strlen($token)>0) return FALSE;
		$mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = array();
		$this->videos->views_history_mark($mem_id, $class_id);
	
		encode_json($response,$data);
	}

	public function follow_videos_list()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$date_limit = $this->input->get_post('date_limit', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
		$this->load->helper('return_time');
		$this->load->helper('time_zone');
		$time = return_time::build();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->follow_videos_list($mem_id, $time, time_zone::build(), $date_limit);
		
		encode_json($response,$data);
	}

	public function follow_mem_videos_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->follow_mem_videos_list($mem_id);
	
		encode_json($response,$data);
	}

	public function detail_recommend_teacher()
	{
		header( 'Access-Control-Allow-Origin:*' );

		$start = $this->input->get_post('start', TRUE);
		$limit = $this->input->get_post('limit', TRUE);

		$client = new Client();
		$client->addServer('localhost', 11211);
		$paras = 'video/detail_recommend_teacher';
		if($cached = $client->get($paras)) {
			exit($cached);
		}

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->detail_recommend_teacher($start, $limit);

		encode_json($response, $data, $client, $paras);
	}

	public function detail_forTeacher()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$teacher_id = $this->input->get_post('teacher_id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('videos');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->videos->detail_forTeacher($teacher_id);
	
		encode_json($response,$data);
	}

	public function import_solr()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->database();
		$this->load->model('videos');
		
		echo json_encode($this->videos->import_solr());
	}

	public function export_solr()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$this->load->helper('solr');
		$solr = solr::build();
		$solr->delete(69);
		// print_r($solr);
	}

	public function test1()
	{
		$paras = 'chenqi';
		$client = new Client();
		$client->addServer('localhost', 11211);
		$client->set($paras, '133'); // Return 1
		echo $client->get($paras); // Return 1
	}
}
