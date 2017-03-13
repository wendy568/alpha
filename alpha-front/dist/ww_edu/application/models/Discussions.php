<?php

class Discussions extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

    function update_wealth($id, $wealth)
    {
        $map = 'UPDATE member 
                SET wealth=wealth+"'.$wealth.'" 
                WHERE id="'.$id.'"';
        
        $query = $this->db->query($map);
    }        

    function list($time, $pagination, $page_nums_per, $pages)
    {    
    	$map = "SELECT c.*, m.nic_name AS name, m.face AS face, count(f.id) AS follow_count 
    			FROM comment c 
    			LEFT JOIN member m 
    			ON c.from_id=m.id
    			LEFT JOIN follow_comment f 
    			ON f.comment_id=c.id 
    			GROUP BY c.id 
                ORDER BY c.id DESC";

        $page_nums_per = $page_nums_per?$page_nums_per:10;
        $pages = $pages?$pages:1;
        $pagination->_db = $this->db;
        $pagination->_map = $map;
        $pagination->page_nums_per = $page_nums_per;
        $pagination->pages = $pages;
        $result = $pagination->set_pages();

        foreach ($result['data'] as $key => $value) 
        {
            preg_match_all('/<img.*?src="(.*?)".*?>/is',$value['content'],$array);
            if (isset($array[1][0])) {
               $result['data'][$key]['src'] = $array[1][0];
            }
            else
            {
                $result['data'][$key]['src'] = '';                
            }

            $time->sec = date('s', strtotime($result['data'][$key]['create_time']));
            $time->day = date('z', strtotime($result['data'][$key]['create_time']));
            $time->mon = date('m', strtotime($result['data'][$key]['create_time']));
            $time->min = date('i', strtotime($result['data'][$key]['create_time']));
            $time->hour = date('H', strtotime($result['data'][$key]['create_time']));
            $time->year = date('Y', strtotime($result['data'][$key]['create_time']));
            $time->yday = time() - strtotime($result['data'][$key]['create_time']);
            $result['data'][$key]['ago_time'] = $time->filter_time();
            $result['data'][$key]['content'] = mb_substr(strip_tags($value['content']), 0, 250,'utf8') ;
            $result['data'][$key]['show'] = FALSE;
            $result['data'][$key]['replay'] = array();
        }
    	return $result;
    }

    function list_person($from_id, $time, $pagination, $page_nums_per, $pages)
    {
        $map = "SELECT c.*, m.nic_name AS name, m.face AS face, count(f.id) AS follow_count 
                FROM comment c 
                LEFT JOIN member m 
                ON c.from_id=m.id
                LEFT JOIN follow_comment f 
                ON f.comment_id=c.id 
                WHERE from_id='".$from_id."'
                GROUP BY c.id";
        
        $page_nums_per = $page_nums_per?$page_nums_per:10;
        $pages = $pages?$pages:1;
        $pagination->_db = $this->db;
        $pagination->_map = $map;
        $pagination->page_nums_per = $page_nums_per;
        $pagination->pages = $pages;
        $result = $pagination->set_pages();

        foreach ($result['data'] as $key => $value) 
        {
            preg_match_all('/<img.*?src="(.*?)".*?>/is',$value['content'],$array);
            if (isset($array[1][0])) {
               $result['data'][$key]['src'] = $array[1][0];
            }
            else
            {
                $result['data'][$key]['src'] = '';                
            }

            $time->sec = date('s', strtotime($result['data'][$key]['create_time']));
            $time->day = date('z', strtotime($result['data'][$key]['create_time']));
            $time->mon = date('m', strtotime($result['data'][$key]['create_time']));
            $time->min = date('i', strtotime($result['data'][$key]['create_time']));
            $time->hour = date('H', strtotime($result['data'][$key]['create_time']));
            $time->year = date('Y', strtotime($result['data'][$key]['create_time']));
            $result['data'][$key]['ago_time'] = $time->filter_time();
            $result['data'][$key]['content'] = mb_substr(strip_tags($value['content']), 0, 250,'utf8') ;
            $result['data'][$key]['show'] = FALSE;
            $result['data'][$key]['replay'] = array();
        }

        return $result;
    }

    function comment_list_relation($from_id, $time, $pagination, $page_nums_per, $pages)
    {
        $map = 'SELECT GROUP_CONCAT(mem_id) AS mem_id
                FROM follow
                WHERE from_id="'.$from_id.'"';
        
        $result = $this->db->query($map)->row_array();
        if (!$result['mem_id']) {
            return array();
        }
        $where = $result['mem_id']?'WHERE from_id in ('.$result['mem_id'].')':NULL;
        
        $map = "SELECT c.*, m.nic_name AS name, m.face AS face, count(f.id) AS follow_count 
                FROM comment c 
                LEFT JOIN member m 
                ON c.from_id=m.id
                LEFT JOIN follow_comment f 
                ON f.comment_id=c.id 
                {$where} 
                GROUP BY c.id";
        
        $page_nums_per = $page_nums_per?$page_nums_per:10;
        $pages = $pages?$pages:1;
        $pagination->_db = $this->db;
        $pagination->_map = $map;
        $pagination->page_nums_per = $page_nums_per;
        $pagination->pages = $pages;
        $result = $pagination->set_pages();

        foreach ($result['data'] as $key => $value) 
        {
            preg_match_all('/<img.*?src="(.*?)".*?>/is',$value['content'],$array);
            if (isset($array[1][0])) {
               $result['data'][$key]['src'] = $array[1][0];
            }
            else
            {
                $result['data'][$key]['src'] = '';                
            }

            $time->sec = date('s', strtotime($result['data'][$key]['create_time']));
            $time->day = date('z', strtotime($result['data'][$key]['create_time']));
            $time->mon = date('m', strtotime($result['data'][$key]['create_time']));
            $time->min = date('i', strtotime($result['data'][$key]['create_time']));
            $time->hour = date('H', strtotime($result['data'][$key]['create_time']));
            $time->year = date('Y', strtotime($result['data'][$key]['create_time']));
            $result['data'][$key]['ago_time'] = $time->filter_time();
            $result['data'][$key]['content'] = mb_substr(strip_tags($value['content']), 0, 250,'utf8') ;
            $result['data'][$key]['show'] = FALSE;
            $result['data'][$key]['replay'] = array();
        }

        return $result;
    }

    function discuss_list($pid, $time, $pagination, $page_nums_per, $pages)
    {
    	$map = 'SELECT * 
    			FROM comment_from_to
    			WHERE pid="'.$pid.'" 
                ORDER BY id ASC';
    	
    	$page_nums_per = $page_nums_per?$page_nums_per:30;
        $pages = $pages?$pages:1;
        $pagination->_db = $this->db;
        $pagination->_map = $map;
        $pagination->page_nums_per = $page_nums_per;
        $pagination->pages = $pages;
        $result = $pagination->set_pages();

        foreach ($result['data'] as $key => $value) 
        {
            $time->sec = date('s', strtotime($result['data'][$key]['create_time']));
            $time->day = date('z', strtotime($result['data'][$key]['create_time']));
            $time->mon = date('m', strtotime($result['data'][$key]['create_time']));
            $time->min = date('i', strtotime($result['data'][$key]['create_time']));
            $time->hour = date('H', strtotime($result['data'][$key]['create_time']));
            $time->year = date('Y', strtotime($result['data'][$key]['create_time']));
            $result['data'][$key]['ago_time'] = $time->filter_time();
        }

    	return $result;
    }

    function child_list($id, $time)
    {
        $map = 'SELECT * 
                FROM comment_from_to
                WHERE c_list_id="'.$id.'"';
        
        $query = $this->db->query($map);
        $result = $query->result_array();

        foreach ($result as $key => $value) 
        {
            $time->sec = date('s', strtotime($result[$key]['create_time']));
            $time->day = date('z', strtotime($result[$key]['create_time']));
            $time->mon = date('m', strtotime($result[$key]['create_time']));
            $time->min = date('i', strtotime($result[$key]['create_time']));
            $time->hour = date('H', strtotime($result[$key]['create_time']));
            $time->year = date('Y', strtotime($result[$key]['create_time']));
            $result[$key]['ago_time'] = $time->filter_time();
        }

        return $result;
    }

    function post_article($from_id,$title,$content,&$data,&$response,$stas)
    {
        $pid=0;
    	$result = array();
    	$map = 'INSERT discussion(from_id,title,content,pid,create_time) VALUES("'.$from_id.'","'.$title.'","'.$content.'","'.$pid.'","'.date('Y-m-d H:i:s', time()).'")';	
    	$query = $this->db->query($map);
        $result = $this->db->insert_id();   
        
        $stas->statistic($from_id,5,'wealth');
        $stas->statistic($from_id,1,'post_article');
        $this->update_wealth($from_id,5);
        // $this->wealth($from_id,5,'wealth');
        
        $data['data']['result'] = $result?'success':'';
        $response = $result?array('archive' => array('status' => 0,'message' =>'金币 + 5')):array('archive' => array('status' => 20,'message' =>'发表失败'));
    }

    function detail($id)
    {
        $map = 'SELECT content 
                FROM discussion
                WHERE id="'.$id.'"';
        
        $query = $this->db->query($map);
        $result = $query->row_array();
        return $result;
    }
    /**
     * 递归找出父级评论id
     * @Author:chenqi
     * @DateTime      2016-07-21T15:27:13+0800
     * @describe      如题
     * @require       null
     * @param         int                   $id to_id
     * @return        int                   int 父级评论id
     */
    function c_list_id($id, $pid)
    {
        $map = 'SELECT id,relation_id 
                FROM discussion
                WHERE id="'.$id.'" and pid='.$pid;
        if(($result = $this->db->query($map)->row_array()) && $result['relation_id']){
            return $this->c_list_id($result['relation_id'], $pid);
        }else{
            return $result['id'];
        }

    }

    function post_chat($pid,$from_id,$to_id, $relation_id, $content,&$data,&$response,$stas)
    {
        if($to_id)
        {
            $result = array();
            $c_list_id = $this->c_list_id($relation_id, $pid);
            $map = 'INSERT discussion(pid,from_id,to_id,relation_id,c_list_id,content,create_time) VALUES("'.$pid.'","'.$from_id.'","'.$to_id.'","'.$relation_id.'","'.$c_list_id.'","'.$content.'","'.date('Y-m-d H:i', time()).'")';    
            $this->db->query($map);
            $result = $this->db->insert_id();

            $map = 'UPDATE discussion 
                SET is_c_list=1
                WHERE id="'.$c_list_id.'"';
        
            $result?$this->db->query($map):null;
        }
        else
        {
            $result = array();
            $map = 'INSERT discussion(pid,from_id,relation_id,content,create_time) VALUES("'.$pid.'","'.$from_id.'","'.$relation_id.'","'.$content.'","'.date('Y-m-d H:i', time()).'")';    
            $this->db->query($map);
            $result = $this->db->insert_id();  
        }
        
        $stas->statistic($from_id,1,'wealth');
        $stas->statistic($from_id,1,'post_chat');
        $this->update_wealth($from_id,1);

        $data['data']['result'] = $result?'success':'';
        $response = $result?array('archive' => array('status' => 0,'message' =>'金币 + 1')):array('archive' => array('status' => 20,'message' =>'发表失败'));
    
    }

    function relation_to_me($from_id, $pid)
    {
        $map = 'SELECT * 
                FROM comment_from_to 
                WHERE pid="'.$pid.'" and (from_id="'.$from_id.'" or to_id="'.$from_id.'")';
        
        $query = $this->db->query($map);
        $result = $query->result_array();
        return $result;
    }

    function follow_comment($comment_id,$mem_id,&$response,$stas)
    {
        $result = array();
        $map = 'SELECT count(*) as count 
                FROM follow_comment
                WHERE comment_id="'.$comment_id.'" and mem_id='.$mem_id;
        
        $query = $this->db->query($map);
        $result = $query->row_array();
        if(!$result['count'])
        {
            $map = 'INSERT follow_comment(comment_id,mem_id) VALUES("'.$comment_id.'","'.$mem_id.'")';
            $query = $this->db->query($map);  

            $stas->statistic($mem_id,1,'follow_comment');

            return 'success';
        }

        $map = 'DELETE FROM follow_comment 
                WHERE comment_id="'.$comment_id.'" AND mem_id='.$mem_id;
        
        $query = $this->db->query($map);

        $stas->statistic($mem_id,1,'cancel_follow_comment');

        $response = array('archive' => array('status' => 38,'message' =>'你已经取消关注改文章'));
        return 'cancel';
    }

    function is_follow($comment_id, $mem_id, &$response, &$data)
    {
        $res = array();
        $map = 'SELECT count(*) as count, comment_id 
                FROM follow_comment
                WHERE comment_id in('.$comment_id.') AND mem_id='.$mem_id.'  
                GROUP BY id';
        
        $query = $this->db->query($map);
        $result = $query->result_array();

        foreach ($result as $key => $value) {
            $res[] = array('comment_id' => $value['comment_id']);     
        }
        $data['data'] = $res;
        $response = (isset($res) && $res)?$response:array('archive' => array('status' => 533,'message' =>''));
    }

    function follow_list_comment($comment_id)
    {
        $data = array();
        $map = 'SELECT f.*, m.nic_name, m.face, m.wealth, count(c.id) AS comment_count 
                FROM follow_comment f 
                LEFT JOIN member m 
                ON m.id=f.mem_id
                LEFT JOIN comment c 
                ON c.from_id=f.mem_id
                WHERE comment_id="'.$comment_id.'"
                GROUP BY f.id';
        
        $query = $this->db->query($map);
        $result = $query->result_array();

        return $result;
    }

    function follow_list_person($mem_id)
    {
        $map = 'SELECT f.*, c.title  
                FROM follow_comment f 
                LEFT JOIN comment c 
                ON c.id=f.comment_id
                WHERE mem_id="'.$mem_id.'"';
        
        $query = $this->db->query($map);
        $result = $query->result_array();
        return $result;
    }

    function test()
    {    
        $map = "SELECT c.*, m.nic_name AS name, m.face AS face, count(f.id) AS follow_count 
                FROM comment c 
                LEFT JOIN member m 
                ON c.from_id=m.id
                LEFT JOIN follow_comment f 
                ON f.comment_id=c.id 
                GROUP BY c.id 
                ORDER BY c.id DESC";

        $query = $this->db->query($map);
        $result = $query->result_array();

        foreach ($result as $key => $value) 
        {
            preg_match_all('/<img.*?src="(.*?)".*?>/is',$value['content'],$array);
            if (isset($array[1][0])) {
               $result[$key]['src'] = $array[1][0];
            }
        }
        return $result;
    }

}














