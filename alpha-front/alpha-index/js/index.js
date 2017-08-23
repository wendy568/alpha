(function(){
	// 视频播放窗口
    request_Url('post','video/videos_detail',{'class_id':9},function(data){
        // 视频播放窗口
        var big_html="";
        big_html+= '<iframe id="tv" src="http://content.jwplatform.com/players/'+data.data.source+'-T351KaXB.html" width="100%" height="100%" frameborder="0" allowfullscreen name="tv"></iframe>';
        $('.index-video').html(big_html);
    });

    
    // learning  tabs
    $('.list-bottom li').hover(function(){
    	var liIndex = $(this).index();
    	$(this).addClass('active');
    	$(this).siblings().removeClass('active');
    	$('.learn-list').eq(liIndex).removeClass('hide');
    	$('.learn-list').eq(liIndex).siblings().addClass('hide');
    });

})();	