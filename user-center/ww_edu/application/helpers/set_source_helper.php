<?php
    
    function get_image($width=500, $height=500, $file_name)
    {
        $date = getdate();

        $s_width = $width/4;
        $s_height = $height/4;

        $upload = './upload/';
        $upload .= $file_name.'/';

        if(!is_dir($upload)) mkdir($upload);
        if(!is_dir($upload.$date['year'].'/')) mkdir($upload.$date['year'].'/');
        if(!is_dir($upload.$date['year'].'/'.$date['mon'].'/')) mkdir($upload.$date['year'].'/'.$date['mon'].'/');

        $upload .= $date['year'].'/'.$date['mon'].'/'.$date['mday'].'/';

		$ci = & get_instance();
		$ci->load->library('uploadfile');
        //设置上传文件大小
		$ci->uploadfile->maxSize            = 3292200;
        //设置上传文件类型
        $ci->uploadfile->allowExts          = explode(',', 'jpg,gif,png,jpeg');
        //设置附件上传目录
        $ci->uploadfile->savePath           = $upload;
        //设置需要生成缩略图，仅对图像文件有效
        $ci->uploadfile->thumb              = true;
        // 设置引用图片类库包路径
        $ci->uploadfile->imageClassPath     = 'Image';
        //设置需要生成缩略图的文件后缀
        $ci->uploadfile->thumbPrefix        = 'm_,s_';  //生产2张缩略图
        //设置缩略图最大宽度
        $ci->uploadfile->thumbMaxWidth      = "{$width},{$s_width}";
        //设置缩略图最大高度
        $ci->uploadfile->thumbMaxHeight     = "{$height},{$s_height}";
        //设置上传文件规则
        $ci->uploadfile->saveRule           = 'uniqid';
        //删除原图
        $ci->uploadfile->thumbRemoveOrigin  = true;
        //如果上传不成功
        if (!$ci->uploadfile->upload()) 
        {
            //捕获上传异常
            // echo $ci->uploadfile->getErrorMsg();
        } 
        else 
        {
            //取得成功上传的文件信息
            $uploadList = $ci->uploadfile->getuploadfileInfo();
            return json_encode(array($date['year'].'/'.$date['mon'].'/'.$date['mday'].'/',$uploadList[0]['savename']));
        }
    }

    function cut_image($file_name, $dir_name, $new_width, $new_height, $x, $y, $ratio = 1, &$face, &$response ,&$data)
    {
        $ori = 'upload/';
        $unique = time();
        $no = mt_rand(100,999);
        $m_save_name = $ori.$file_name.'m_'.$unique.$no.'_cut'.'.'.'jpg';
        $s_save_name = $ori.$file_name.'s_'.$unique.$no.'_cut'.'.'.'jpg';
        
        $image_p = imagecreatetruecolor($new_width, $new_height);

        @$image = imagecreatefromjpeg($ori.$file_name.'m_'.$dir_name);
        if (empty($image)) {
            @$image = imagecreatefromgif($ori.$file_name.'m_'.$dir_name);
        }
        if (empty($image)) {
            @$image = imagecreatefrompng($ori.$file_name.'m_'.$dir_name);
        }
 
        if (empty($image)) {
            $response = array('archive' => array('status' => 1001,'message' =>'image create failed'));
            return FALSE;
        }
        
        imagecopyresampled($image_p, $image, 0, 0, $x, $y, $new_width, $new_height, $new_width/$ratio, $new_height/$ratio);
        if($image_p)
        {
            array_map('unlink', glob($ori.$file_name.'*'.$dir_name));
            $face = addslashes(json_encode(array($file_name,$unique.$no.'_cut'.'.'.'jpg')));          
            $data = array('data' => array('face' => $unique.$no.'_cut'.'.'.'jpg'));
        }
        else
        {
            $response = array('archive' => array('status' => 1002,'message' =>'image cut failed'));
            return FALSE;
        }
        // header('Content-type: image/jpeg');
        imagejpeg($image_p, $m_save_name, 100);
        imagejpeg($image_p, $s_save_name, 50);
    }











