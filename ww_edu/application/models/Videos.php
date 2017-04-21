<?php  

class Videos extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function list($limit, $time, $start, $cat_id)
	{
		$start = $start?$start:0;
		$limit = $limit?$limit:10;
		$where = ($cat_id)?"AND ct.cat_id={$cat_id}":NULL;
		$map = "SELECT ct.*,m.face,m.nic_name 
				FROM classes_text ct 
				LEFT JOIN member m 
				ON m.id=ct.from_id 
				WHERE 1=1
				-- AND ct.recommend=1 
				$where
				limit {$start},{$limit}";
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) 
        {
            $time->sec = date('s', strtotime($result[$key]['create_time']));
            $time->day = date('z', strtotime($result[$key]['create_time']));
            $time->mon = date('m', strtotime($result[$key]['create_time']));
            $time->min = date('i', strtotime($result[$key]['create_time']));
            $time->hour = date('H', strtotime($result[$key]['create_time']));
            $time->year = date('Y', strtotime($result[$key]['create_time']));
            $result[$key]['ago_time'] = $time->filter_time();
            $result[$key]['face'] = json_decode($result[$key]['face']);
            $result[$key]['image'] = json_decode($result[$key]['image']);
        }
		return $result;
	}

	function video_info_count($class_id, $from_id)
	{
		$map = 'SELECT count(*) AS message_count
				FROM message
				WHERE class_id="'.$class_id.'"';
		
		$result['message_count'] = $this->db->query($map)->row_array();

		// $map = 'SELECT count(*) AS like_count 
		// 	FROM video_like
		// 	WHERE class_id='.$class_id;
	
		// $result['like_count'] = $this->db->query($map)->row_array();
		$map = 'SELECT count(*) AS collection 
			FROM follow_video
			WHERE class_id='.$class_id;
	
		$result['collection'] = $this->db->query($map)->row_array();


		$map = 'SELECT count(*) AS follow_count
				FROM follow
				WHERE mem_id="'.$from_id.'"';
		
		$result['follow_count'] = $this->db->query($map)->row_array();

		$result = array_merge($result['collection'], $result['message_count'], $result['follow_count']);
		return $result;
	}

	function videos_detail($id, $time)
	{
		$map = 'SELECT co.*,m.face,m.nic_name
				FROM classes_online co
				LEFT JOIN member m
				ON m.id=co.from_id
				WHERE co.id="'.$id.'"';
		
		$result['detail'] = $this->db->query($map)->row_array();
		$result['count'] = $this->video_info_count($id, $result['detail']['from_id']);
		$result = array_merge($result['detail'], $result['count']);

        $time->sec = date('s', strtotime($result['create_time']));
        $time->day = date('z', strtotime($result['create_time']));
        $time->mon = date('m', strtotime($result['create_time']));
        $time->min = date('i', strtotime($result['create_time']));
        $time->hour = date('H', strtotime($result['create_time']));
        $time->year = date('Y', strtotime($result['create_time']));
        $result['ago_time'] = $time->filter_time();
        $result['face'] = json_decode($result['face']);
        $result['image'] = json_decode($result['image']);
		return $result;
	}

	function like($mem_id,$class_id)
	{
		$map = 'SELECT count(*) AS count  
				FROM video_like
				WHERE mem_id="'.$mem_id.'" and class_id='.$class_id;
		
		$result = $this->db->query($map)->row_array();
		if ($result['count']) {

			$map = 'UPDATE classes_online 
					SET `like`=`like`-1 
					WHERE id="'.$class_id.'"';
			
			$this->db->query($map);
			
			$map = 'DELETE FROM `video_like` 
					WHERE mem_id="'.$mem_id.'" AND class_id="'.$class_id.'"';
		}else{
			$map = 'UPDATE classes_online 
					SET `like`=`like`+1 
					WHERE id="'.$class_id.'"';
			
			$this->db->query($map);

			$map = 'INSERT video_like(mem_id,class_id) VALUES("'.$mem_id.'","'.$class_id.'")';	
		}
		$this->db->query($map);

	}

	function follow_video($mem_id,$class_id)
	{
		$map = 'SELECT count(*) AS count 
				FROM follow_video 
				WHERE mem_id="'.$mem_id.'" and class_id='.$class_id;
		
		$result = $this->db->query($map)->row_array();
		if ($result['count']) {
			$map = 'DELETE FROM `follow_video` 
					WHERE mem_id="'.$mem_id.'" AND class_id="'.$class_id.'"';
		}else{
			$map = 'INSERT follow_video(mem_id,class_id,create_time) VALUES("'.$mem_id.'","'.$class_id.'","'.date('Y-m-d H:i:s', time()).'")';	
		}
		$this->db->query($map);

	}

	function is_like_follow($mem_id,$class_id)
	{
		$map = 'SELECT count(*) AS is_like 
				FROM video_like
				WHERE mem_id="'.$mem_id.'" and class_id='.$class_id;
		
		$result['like'] = $this->db->query($map)->row_array();
		$map = 'SELECT count(*) AS is_follow 
				FROM follow_video
				WHERE mem_id="'.$mem_id.'" and class_id='.$class_id;
		
		$result['follow'] = $this->db->query($map)->row_array();
		return $result;
	}

	function message_list($class_id, $time, $limit, $start, $from_id)
	{
		$where = '';
		$start = $start?$start:0;
		$limit = $limit?$limit:10;
		$where .= $from_id?'AND from_id='.$from_id:NULL;
		$map = "SELECT * 
				FROM message_from_to
				WHERE 1=1 
				{$where}
				AND class_id='".$class_id."'
				AND pid=0 
				ORDER BY id DESC
				LIMIT {$start},{$limit}";

		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) 
        {
            $time->sec = date('s', strtotime($result[$key]['create_time']));
            $time->day = date('z', strtotime($result[$key]['create_time']));
            $time->mon = date('m', strtotime($result[$key]['create_time']));
            $time->min = date('i', strtotime($result[$key]['create_time']));
            $time->hour = date('H', strtotime($result[$key]['create_time']));
            $time->year = date('Y', strtotime($result[$key]['create_time']));
            $result[$key]['ago_time'] = $time->filter_time();
            $result[$key]['from_face'] = json_decode($result[$key]['from_face']);
            $result[$key]['to_face'] = json_decode($result[$key]['to_face']);
        }
		return $result;
	}

	function reply_message_list($class_id,$pid, $time)
	{
		$map = 'SELECT * 
				FROM message_from_to
				WHERE pid="'.$pid.'" 
				AND class_id='.$class_id;
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) 
        {
            $time->sec = date('s', strtotime($result[$key]['create_time']));
            $time->day = date('z', strtotime($result[$key]['create_time']));
            $time->mon = date('m', strtotime($result[$key]['create_time']));
            $time->min = date('i', strtotime($result[$key]['create_time']));
            $time->hour = date('H', strtotime($result[$key]['create_time']));
            $time->year = date('Y', strtotime($result[$key]['create_time']));
            $result[$key]['ago_time'] = $time->filter_time();
            $result[$key]['from_face'] = json_decode($result[$key]['from_face']);
            $result[$key]['to_face'] = json_decode($result[$key]['to_face']);
        }
		return $result;
	}

	function reply_message($from_id,$to_id,$class_id,$pid,$content)
	{
		$result = array();
		if ($to_id) {
			$map = 'INSERT message(from_id,to_id,class_id,pid,content,create_time) VALUES ("'.$from_id.'","'.$to_id.'","'.$class_id.'","'.$pid.'","'.$content.'","'.date('Y-m-d H:i:s', time()).'")';	
		} else {
			$map = 'INSERT message(from_id,class_id,pid,content,create_time) VALUES ("'.$from_id.'","'.$class_id.'","'.$pid.'","'.$content.'","'.date('Y-m-d H:i:s', time()).'")';
		}

		$this->db->query($map);
	    
	    return $result;
	
	}

	function click_views($id)
	{
		$map = 'UPDATE classes_online 
				SET views=views+1
				WHERE id="'.$id.'"';
		
		$this->db->query($map);
	}		
	
	function event()
	{
		$map = 'SELECT * 
				FROM event
				WHERE class_begin>"'.date('Y-m-d H:i:s', time()).'"';
		
		$result = $this->db->query($map)->result_array();
		return $result;
	}

	function live_on_now()
	{
		$result = array();
		$time = date('Y-m-d H:i:s', time());
		$map = 'SELECT name, source, create_time, image, class_begin, class_over, `describe`, views  
				FROM classes_online
				WHERE class_begin<"'.$time.'"
				AND class_over>"'.$time.'"
				AND cat_id=1';
		
		$result = $this->db->query($map)->row_array();
		if(!empty($result)) $result['image'] = json_decode($result['image']);

		return $result;
	}

	function views_history($mem_id, $time, $time_zone, $date_limit)
	{
		$date_end = '';
		$date_begin = '';
		if ($date_limit == 1) {
			// $date_c = $time_zone->todayBegin()->get_time_zone();
			$date_begin = date('Y-m-d H:i:s', $time_zone->todayBegin()->get_time_zone());
			$date_end = date('Y-m-d H:i:s', $time_zone->todayEnd()->get_time_zone());
		}elseif($date_limit == 2){
			$date_begin = date('Y-m-d H:i:s', $time_zone->sundayOfTheWeekOfBegin()->get_time_zone());
			$date_end = date('Y-m-d H:i:s', $time_zone->sundayOfTheWeekOfEnd()->get_time_zone());
		}elseif($date_limit == 3){
			$date_begin = date('Y-m-d H:i:s', $time_zone->lastDayInMonthOfBegin()->get_time_zone());
			$date_end = date('Y-m-d H:i:s', $time_zone->lastDayInMonthOfEnd()->get_time_zone());
		}elseif($date_limit == 4){
			$date_end = date('Y-m-d H:i:s', $time_zone->lastDayInMonthOfBegin()->get_time_zone());
		}

		// echo $date_begin;
		// echo '|||';
		// echo $date_end;
		$where  = ($date_end)?' AND create_time<"'.$date_end.'"':NULL;
		$where .= ($date_begin)?' AND create_time>"'.$date_begin.'"':NULL;
		$map = 'SELECT GROUP_CONCAT(class_id) AS class_id
				FROM browse_mark
				WHERE mem_id="'.$mem_id.'"' . $where;
		
		$result = $this->db->query($map)->row_array();
		$result = !empty($result['class_id'])?$result['class_id']:'0,0';
		// print_r($result);
		$map = 'SELECT c.*, m.nic_name, m.face 
				FROM classes_text c
				LEFT JOIN member m
				ON m.id=c.from_id
				WHERE c.class_id in('.$result.')';
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) 
        {
            $time->sec = date('s', strtotime($result[$key]['create_time']));
            $time->day = date('z', strtotime($result[$key]['create_time']));
            $time->mon = date('m', strtotime($result[$key]['create_time']));
            $time->min = date('i', strtotime($result[$key]['create_time']));
            $time->hour = date('H', strtotime($result[$key]['create_time']));
            $time->year = date('Y', strtotime($result[$key]['create_time']));
            $result[$key]['ago_time'] = $time->filter_time();
            $result[$key]['face'] = json_decode($result[$key]['face']);
            $result[$key]['image'] = json_decode($result[$key]['image']);

        }
		return $result;
	}
	
	function views_history_mark($mem_id,$class_id)
	{
		$map = 'SELECT count(*) AS count 
				FROM browse_mark 
				WHERE mem_id="'.$mem_id.'" and class_id='.$class_id;
		
		$result = $this->db->query($map)->row_array();
		if ($result['count']) {
			$map = 'UPDATE browse_mark 
				SET create_time="'.date('Y-m-d H:i:s', time()).'"
				WHERE mem_id="'.$mem_id.'"
				AND class_id="'.$class_id.'"';
		}else{
			$map = 'INSERT browse_mark(mem_id,class_id,create_time) VALUES("'.$mem_id.'","'.$class_id.'","'.date('Y-m-d H:i:s', time()).'")';	
		}
		$this->db->query($map);
	}

	function follow_videos_list($mem_id, $time, $time_zone, $date_limit)
	{
		$date_end = '';
		$date_begin = '';
		if ($date_limit == 1) {
			// $date_c = $time_zone->todayBegin()->get_time_zone();
			$date_begin = date('Y-m-d H:i:s', $time_zone->todayBegin()->get_time_zone());
			$date_end = date('Y-m-d H:i:s', $time_zone->todayEnd()->get_time_zone());
		}elseif($date_limit == 2){
			$date_begin = date('Y-m-d H:i:s', $time_zone->sundayOfTheWeekOfBegin()->get_time_zone());
			$date_end = date('Y-m-d H:i:s', $time_zone->sundayOfTheWeekOfEnd()->get_time_zone());
		}elseif($date_limit == 3){
			$date_begin = date('Y-m-d H:i:s', $time_zone->lastDayInMonthOfBegin()->get_time_zone());
			$date_end = date('Y-m-d H:i:s', $time_zone->lastDayInMonthOfEnd()->get_time_zone());
		}elseif($date_limit == 4){
			$date_end = date('Y-m-d H:i:s', $time_zone->lastDayInMonthOfBegin()->get_time_zone());
		}

		$where  = ($date_end)?' AND create_time<"'.$date_end.'"':NULL;
		$where .= ($date_begin)?' AND create_time>"'.$date_begin.'"':NULL;

		$map = 'SELECT GROUP_CONCAT(class_id) AS class_id
				FROM follow_video
				WHERE mem_id="'.$mem_id.'"' . $where;

		$result = $this->db->query($map)->row_array();
		$result = !empty($result['class_id'])?$result['class_id']:'0,0';
		$map = 'SELECT c.*, m.nic_name, m.face 
				FROM classes_text c
				LEFT JOIN member m
				ON m.id=c.from_id
				WHERE c.class_id in('.$result.')';
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) 
        {
            $time->sec = date('s', strtotime($result[$key]['create_time']));
            $time->day = date('z', strtotime($result[$key]['create_time']));
            $time->mon = date('m', strtotime($result[$key]['create_time']));
            $time->min = date('i', strtotime($result[$key]['create_time']));
            $time->hour = date('H', strtotime($result[$key]['create_time']));
            $time->year = date('Y', strtotime($result[$key]['create_time']));
            $result[$key]['ago_time'] = $time->filter_time();
            $result[$key]['face'] = json_decode($result[$key]['face']);
            $result[$key]['image'] = json_decode($result[$key]['image']);
        }
		return $result;
	}

	function follow_mem_videos_list($id)
	{

		$map = 'SELECT GROUP_CONCAT(mem_id) AS id 
				FROM follow
				WHERE from_id="'.$id.'"';
		
		$result = $this->db->query($map)->row_array();
		$result = !empty($result['id'])?$result['id']:'0,0';

		// $map = 'SELECT m.id AS teacher_id, m.username, m.face, ui.`describe`, COUNT(co.id) AS videos_count, GROUP_CONCAT(co.id) AS class_id, SUM(co.`like`) AS likes 
		// 		FROM member m 
		// 		LEFT JOIN user_info ui 
		// 		ON ui.mem_id=m.id 
		// 		LEFT JOIN classes_online co 
		// 		ON co.from_id=m.id
		// 		WHERE m.id in ('.$result.') 
		// 		GROUP BY m.id';
		$map = 'SELECT s.*, COUNT(f.id) AS `subscription` 
				FROM subscription s
				LEFT JOIN follow f 
				ON f.mem_id=s.teacher_id
				WHERE teacher_id IN ('.$result.')
				GROUP BY s.teacher_id';
		
		$result = $this->db->query($map)->result_array();
		foreach ($result as $key => $value) 
        {
            $result[$key]['face'] = json_decode($result[$key]['face']);
        }
		return $result;
	}

	function detail_forTeacher($id)
	{
		$map = 'SELECT s.*, COUNT(f.id) AS `subscription` 
				FROM subscription s
				LEFT JOIN follow f 
				ON f.mem_id=s.teacher_id
				WHERE teacher_id='.$id.'
				GROUP BY s.teacher_id';
		
		$result = $this->db->query($map)->row_array();

		$result['class_id'] = !empty($result['class_id']) ? $result['class_id'] : '0,0';
		$result['face'] = json_decode($result['face']);

		$map = 'SELECT  ct.class_id, ct.name, ct.views, ct.image, ct.source  
				From classes_text ct 
				WHERE class_id IN ('.$result['class_id'].')';

		$result['videos'] = $this->db->query($map)->result_array();

		foreach ($result['videos'] as $key => $value) {
			$result['videos'][$key]['image'] = json_decode($result['videos'][$key]['image']);
		}

		return $result;
	}

	function detail_recommend_teacher($start, $limit)
	{
		$map = 'SELECT m.id AS teacher_id, m.nic_name, m.face, ui.`describe`, COUNT(co.id) AS videos_count, GROUP_CONCAT(co.id) AS class_id, SUM(co.`like`) AS likes, co.image AS video_image, co.id AS video_id, co.source   
				FROM member m 
				LEFT JOIN user_info ui 
				ON ui.mem_id=m.id 
				LEFT JOIN classes_online co 
				ON co.from_id=m.id 
				WHERE m.user_type=1 
				GROUP BY m.id';
		
		$result = $this->db->query($map)->result_array();

		foreach ($result as $key => $value) {
			$result[$key]['face'] = json_decode($result[$key]['face']);
			$result[$key]['video_image'] = json_decode($result[$key]['video_image']);
		}

		

		return $result;
	}

	function insert_video_info($cols, &$response, $solr, &$data)
	{	
		$message = '';
		$status = 0;
		$id = array();
		array_walk($cols, function($val, $key) use (&$message, $solr, &$id){
			if($this->db->query($val)){
				$id = $this->db->insert_id();
				$map = 'SELECT * 
						FROM classes_online
						WHERE id="'.$id.'"';

				$search_result = $this->db->query($map)->row_array();
				$solr->add_update($search_result);
				$message .= "{$key}模型更新成功,";
			}else{
				$message .= "{$key}模型更新失败,";
				$status = 39;
			}
		});
		$data['data']['id'] = $id;
		$response = array('archive' => array('status' => $status,'message' =>substr($message, 0, -1)));
	}

	function update_video_info($cols, &$response, $solr, $id)
	{	
		$message = '';
		$status = 0;
		array_walk($cols, function($val, $key) use (&$message, $solr, $id){
			if($this->db->query($val)){
				$map = 'SELECT * 
						FROM classes_online
						WHERE id="'.$id.'"';

				$search_result = $this->db->query($map)->row_array();
				$solr->add_update($search_result);
				$message .= "{$key}模型更新成功,";
			}else{
				$message .= "{$key}模型更新失败,";
				$status = 39;
			}
		});
		$response = array('archive' => array('status' => $status,'message' =>substr($message, 0, -1)));
	}

	function delete_video($source, $id, &$response)
	{
		$map = 'DELETE FROM classes_online 
				WHERE id="'.$id.'" 
				AND source="'.$source.'"';
		
		$this->db->query($map);
		
		$response = array('archive' => array('status' => 0,'message' =>'success'));
	}

	function delete_video_else($id)
	{
		$map = 'DELETE FROM classes_online 
				WHERE id="'.$id.'"';

		$this->db->query($map);
	}

	function import_solr()
	{
		$map = "SELECT ct.*,m.face,m.nic_name
				FROM classes_text ct
				LEFT JOIN member m
				ON m.id=ct.from_id
				WHERE ct.cat_id=2 
				ORDER BY ct.views ASC";
		
		$result = $this->db->query($map)->result_array();
		return $result;
	}
}
