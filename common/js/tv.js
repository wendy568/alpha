(function(){
    // 视频播放窗口
    $.alpha.request_Url('post','video/videos_detail',{'class_id':9},function(data){
        // 视频播放窗口
        var big_html="";
        big_html+= '<iframe id="tv" src="http://content.jwplatform.com/players/'+data.data.source+'-T351KaXB.html" width="100%" height="100%" frameborder="0" allowfullscreen name="tv"></iframe>';
        $('.tv-preview').html(big_html);
        // 视频介绍
        var intr_html="";
        intr_html+=
            ['<div class="video-title m-b-20">',
                '<i class="fa fa-video-camera text-c2"></i>',
                '<span class="font12">&nbsp;'+data.data.create_time+'</span>',
            '</div>',
            '<div class="video-body">',
                '<h4 class="text-c2 semi-bold font24 m-b-20">'+data.data.name+'</h4>',
                '<span class="font14" style="text-indent: 1em;">'+data.data.describe+'</span><br>',
            '</div>'].join('');
        $('.video-intr').html(intr_html);
        // <div class="overall">
        //     <h6 class="text-c3 font14 m-b-20">Overall Visits</h6>
        //     <h5 class="text-c2 font16">${data.data.views}</h5>
        //     <p><i class="fa fa-play text-error"></i></p>
        // </div>
        // <div class="overall pull-right">
        //     <h6 class="text-c3 font14 m-b-20">Comment</h6>
        //     <h5 class="text-c2 font16">${data.data.message_count}</h5>
        //     <p><i class="fa fa-comments text-info"></i></p>
        // </div>
    });

    // 视频列表
    $.alpha.request_Url('post','video/list',{'limit':20,'start':0},function(data){
        var list_html="";
        $.each(data.data,function(i,data){
            var tvT=((data.length)/60).toPrecision(3);
            var tvS=tvT.substring(0,1) + '"';
            var tvH=tvT.slice(2,4);
            var tvTime=tvS + tvH;
            var li = document.createElement('li');

            $(li).addClass('tv-small col-lg-3 col-md-4 col-sm-6 col-xs-12 m-b-30')
            .attr({
                id: data.id
            })
            .html(
                ['<div class="bk-img">',
                    '<img src="'+alpha_host+'upload/'+data.image[0]+'m_'+data.image[1]+'" alt="" ">',
                '</div>',
                '<!-- 遮罩 -->',
                '<div class="tv-date text-c3">'+tvTime+'</div>',
                '<img class="tv-btn img-responsive" src="./assets/img/dashboard_tv_play.png" alt="">',
                '<div class="tv-des">',
                    '<p class="text-c2">'+data.name+'</p>',
                '</div>'].join(''));

            $('.tv-content>ul').append(li);
        });
        // video list detail
        $('.tv-content>ul').on('click','.tv-small',function(){
            var vmid=$(this).attr('id');
            $.alpha.request_Url('post','video/videos_detail',{class_id:vmid},function(data){
                var big_html="";
                big_html+=
                '<iframe id="tv" src="http://content.jwplatform.com/players/'+data.data.source+'-T351KaXB.html" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>';

                $('.tv-preview').html(big_html);

                var intr_html="";
                intr_html+=
                    ['<div class="video-title m-b-20">',
                    '<i class="fa fa-video-camera text-c2"></i>',
                    '<span class="font12">&nbsp;'+data.data.create_time+'</span>',
                    '</div>',
                    '<div class="video-body">',
                    '<h4 class="text-c2 semi-bold font24 m-b-20">'+data.data.name+'</h4>',
                    '<span class="font14" style="text-indent: 1em;">'+data.data.describe+'</span><br>',
                    '</div>'].join('');
                $('.video-intr').html(intr_html);
                $(document).scrollTop(0);
            });
        });
    });
    
    // 改变窗口大小，做视频自适应
    $(window).resize(function() {
      var width = $('.tv-preview').width();
      setTimeout(function () {
        var height = (width*9/16).toFixed(2);
        $('.tv-preview').height(height).next('div').height(height);
      });
    });

    window.setTimeout(function () {
      $('.tv-preview').height(($('.tv-preview').width()*9/16).toFixed(2)).next('div').height(($('.tv-preview').width()*9/16).toFixed(2));
    });
})();
