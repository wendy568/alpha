<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>UploadiFive Test</title>
<script src="<?=base_url()?><?=STATIC_JS?>jquery.min.js" type="text/javascript"></script>
<script src="<?=base_url()?><?=STATIC_JS?>jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?><?=STATIC_CSS?>uploadify.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
</style>
</head>

<body>
	<h1>图片上传测试</h1>
	<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
	</form>
	<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : "<?=base_url()?><?=STATIC_JS?>uploadify.swf",
				'uploader' : "<?=site_url(['set','image','500','500'])?>",
				'method'   : "post",
				'fileObjName' : 'image',  //后台接收的时候就是$_FILES['image'] 
				// 'uploadLimit'   : 3, //设置最大上传文件的数量
				'onUploadSuccess' : function(file, data, response) 
				{
					var obj = JSON.parse(data);
					// var image = [];
     // 				image['image'] = obj['image'].split(',');
     				// image['id'] = obj['id'];
 					var image_show = template.render('image_shows',obj);
					$('#image_show_'+"{$item['id']}").append(image_show);
     			},
			});
		});
	</script>
</body>
</html>