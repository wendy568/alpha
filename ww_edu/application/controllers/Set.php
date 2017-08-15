<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set extends MY_Controller {

	public function image($width, $height)
	{
        $this->load->database();
		$this->load->library('uploadfile');
        $this->load->model('images');
		$this->uploadfile->maxSize            = 3292200;
        //设置上传文件类型
        
        $this->uploadfile->allowExts          = explode(',', 'jpg,gif,png,jpeg');
        //设置附件上传目录
        $this->uploadfile->savePath           = './upload/';
        //var_dump('cms/Public/Home/images/个人资料');
        //设置需要生成缩略图，仅对图像文件有效
        $this->uploadfile->thumb              = true;
        // 设置引用图片类库包路径
        $this->uploadfile->imageClassPath     = 'ImageFile';
        //设置需要生成缩略图的文件后缀
        $this->uploadfile->thumbPrefix        = 'm_,s_';  //生产2张缩略图
        //设置缩略图最大宽度
        $this->uploadfile->thumbMaxWidth      = "{$width},{$width}/4";
        //设置缩略图最大高度
        $this->uploadfile->thumbMaxHeight     = "{$height},{$height}/4";
        //设置上传文件规则
        $this->uploadfile->saveRule           = 'uniqid';
        //删除原图
        $this->uploadfile->thumbRemoveOrigin  = true;
        //如果上传不成功
        // var_dump($this->uploadfile->upload());
        if (!$this->uploadfile->upload()) 
        {
            //捕获上传异常
            // echo $upload->getErrorMsg();
        } 
        else 
        {
            //取得成功上传的文件信息
            $uploadList = $this->uploadfile->getuploadfileInfo();
            // $data = $this->images->image($uploadList[0]['savename']);
            echo json_encode($uploadList[0]['savename']);
        }
	}
	
}
