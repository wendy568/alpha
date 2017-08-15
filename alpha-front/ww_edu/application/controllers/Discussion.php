<?php
class Discussion extends MY_Controller
{

	public function get_bytoken($token)
	{
		header( 'Access-Control-Allow-Origin:*' );
		$this->load->database();
		$this->load->model('login');
		$data = $this->login->get_bytoken($token);
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

	public function comment_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$page_nums_per = $this->input->get_post('page_nums_per', TRUE);
		$pages = $this->input->get_post('pages', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('return_time');
		$this->load->helper('pagination');
		$this->load->model('discussions');
		$pagination = pagination::build();
		$time = return_time::build();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->discussions->list($time, $pagination, $page_nums_per, $pages);
	
		encode_json($response,$data);
	}

	public function comment_list_person()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $token?$this->get_bytoken($token):$this->input->get_post('mem_id', TRUE);
		$page_nums_per = $this->input->get_post('page_nums_per', TRUE);
		$pages = $this->input->get_post('pages', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('return_time');
		$this->load->helper('pagination');
		$this->load->model('discussions');
		$time = return_time::build();
		$pagination = pagination::build();

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->discussions->list_person($mem_id, $time, $pagination, $page_nums_per, $pages);
	
		encode_json($response,$data);
	}

	public function comment_list_relation()
	{
		header( 'Access-Control-Allow-Origin:*' );
		
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $token?$this->get_bytoken($token):$this->input->get_post('mem_id', TRUE);
		$page_nums_per = $this->input->get_post('page_nums_per', TRUE);
		$pages = $this->input->get_post('pages', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('return_time');
		$this->load->helper('pagination');
		$this->load->model('discussions');
		$time = return_time::build();
		$pagination = pagination::build();

		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->discussions->comment_list_relation($mem_id, $time, $pagination, $page_nums_per, $pages);
	
		encode_json($response,$data);
	}

	public function discuss_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$dis_id = $this->input->get_post('dis_id', TRUE);
		$page_nums_per = $this->input->get_post('page_nums_per', TRUE);
		$pages = $this->input->get_post('pages', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('return_time');
		$this->load->helper('pagination');
		$this->load->model('discussions');
		$pagination = pagination::build();
		$time = return_time::build();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->discussions->discuss_list($dis_id, $time, $pagination, $page_nums_per, $pages);
	
		encode_json($response,$data);
	}

	public function child_list()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$dis_id = $this->input->get_post('dis_id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('return_time');
		$this->load->model('discussions');
		
		$time = return_time::build();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->discussions->child_list($dis_id, $time);
	
		encode_json($response,$data);
	}
	// addslashes(json_encode($data,true));
	public function post_article()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$title = $this->input->get_post('title', TRUE);
		$content = $this->input->get_post('content', TRUE);
		$from_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('statistic');
		$stas = custom::build();
		$this->load->model('discussions');

		$data = array();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->discussions->post_article($from_id, $title, addslashes($content), $data, $response, $stas);
	
		encode_json($response,$data);
	}

	public function article_detail()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$dis_id = $this->input->get_post('dis_id', TRUE);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('discussions');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['detail'] = $this->discussions->detail($dis_id);
	
		encode_json($response,$data);
	}

	public function post_chat()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$pid = $this->input->get_post('pid', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$from_id = $this->get_bytoken($token);
		$to_id = $this->input->get_post('to_id', TRUE);
		$content = $this->input->get_post('content', TRUE);
		$relation_id = $this->input->get_post('relation_id', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('statistic');
		$stas = custom::build();
		$this->load->model('discussions');
		$data = array();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->discussions->post_chat($pid, $from_id, $to_id, $relation_id, addslashes($content), $data, $response, $stas);
	
		encode_json($response,$data);
	}

	public function relation_to_me()
	{
		header( 'Access-Control-Allow-Origin:*' );
		$dis_id = $this->input->get_post('dis_id', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);
		
		$this->load->database();
		$this->load->helper('json');
		$this->load->model('discussions');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->discussions->relation_to_me($mem_id,$dis_id);
	
		encode_json($response,$data);
	}

	public function upload()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$width = $this->input->get_post('width', TRUE);
		$height = $this->input->get_post('height', TRUE);
		$file_name = $this->input->get_post('file_name', TRUE);

		$this->load->database();
		$this->load->helper('set_source');
	
		echo get_image($width, $height, $file_name);
			
	}

	public function follow_comment()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$comment_id = $this->input->get_post('comment_id', TRUE);
		$mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('statistic');
		$stas = custom::build();
		$this->load->model('discussions');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data']['is_follow'] = $this->discussions->follow_comment($comment_id, $mem_id, $response, $stas);
	
		encode_json($response,$data);
	}

	public function is_follow()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$comment_id = $this->input->get_post('comment_id', TRUE);
		$mem_id = $this->get_bytoken($token);
		$comment_id = implode(',',explode('@', $comment_id));

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('discussions');
		
		$data = array();
		$response = array('archive' => array('status' => 0,'message' =>''));
		$this->discussions->is_follow($comment_id, $mem_id, $response, $data);
	
		encode_json($response,$data);
	}

	public function follow_list_comment()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$comment_id = $this->input->get_post('comment_id', TRUE);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('discussions');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->discussions->follow_list_comment($comment_id);
	
		encode_json($response,$data);
	}

	public function follow_list_person()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$token = $this->input->get_post('token', TRUE);
		$mem_id = $this->get_bytoken($token);

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('discussions');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->discussions->follow_list_person($mem_id);
	
		encode_json($response,$data);
	}

	public function cursor_user_info()
	{
		header( 'Access-Control-Allow-Origin:*' );
	
		$mem_id = $this->input->get_post('mem_id', TRUE);
		$token = $this->input->get_post('token', TRUE);
		$id = $this->get_bytoken_id($token);

		if ($id == $mem_id) {
			return FALSE;
		}

		$this->load->database();
		$this->load->helper('json');
		$this->load->model('personals');
	
		$response = array('archive' => array('status' => 0,'message' =>''));
		$data['data'] = $this->personals->cursor_user_info($mem_id);
	
		encode_json($response,$data);
	}

	public function test()
	{
		$this->load->helper('return_time');
		$time = return_time::build();
		$time->day = 6;
		$time->test();
	}

}






						














