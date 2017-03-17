(function(){
    // 视频播放窗口
    $.alpha.request_Url('post','video/videos_detail',{'class_id':1},function(data){
        // 视频播放窗口
        var big_html="";
        big_html+=
        `<iframe id="tv" src="http://content.jwplatform.com/players/${data.data.source}-T351KaXB.html" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>`;
        $('.tv-preview').html(big_html);

        // 视频介绍
        var intr_html="";
        intr_html+=
            `<div class="video-title">
                    <i class="fa fa-video-camera text-c2"></i>
                    <span>${data.data.create_time}</span>
                </div>
                <div class="video-body">
                    <h4 class="text-c2 semi-bold">${data.data.name}</h4>
                    <span>${data.data.describe}</span><br>
                    <!-- 访问量 -->
                    <div class="overall">
                        <h6 class="text-c3">Overall Visits</h6>
                        <h5 class="text-c2">${data.data.views}</h5>
                        <p><i class="fa fa-play text-error"></i></p>
                    </div>
                    <!-- 评论数 -->
                    <div class="overall pull-right">
                        <h6 class="text-c3">Comment</h6>
                        <h5 class="text-c2">${data.data.message_count}</h5>
                        <p><i class="fa fa-comments text-info"></i></p>
                    </div>
                </div>`;
        $('.video-intr').html(intr_html);
    })

    // 视频列表
    $.alpha.request_Url('post','video/list',{'limit':4,'start':1},function(data){
        var list_html="";
        $.each(data.data,function(i,data){
            console.log(data);
            var li = document.createElement('li');

            $(li).addClass('col-lg-3 tv-small m-b-40')
            .attr({
                id: data.id
            })
            .html(
                `<img src="ww_edu/upload/${data.image[0]}/m_${data.image[1]}" alt="" class="bk-img">
                <div class="tv-date">
                    <h6 class="text-c3">${data.length}</h6>
                </div>
                <img class="tv-btn img-responsive" src="./assets/img/dashboard_tv_play.png" alt="">
                <div class="tv-des">
                    <h5 class="text-c2">${data.name}</h5>
                </div>`);

            $('.tv-content>ul').append(li);
        });
        // video list detail
        $('.tv-content>ul').on('click','.tv-small',function(){
            var vmid=$(this).attr('id');
            console.log(vmid);
             $.ajax({
                type:'POST',
                url:alpha_host+'video/videos_detail',
                data:{'class_id':vmid},
                success:function(videos_detail){
                    var big_html="";
                    big_html+=
                    `<iframe id="tv" src="http://content.jwplatform.com/players/${videos_detail.data.source}-T351KaXB.html" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>`;
            
                    $('.tv-preview').html(big_html);

                    var intr_html="";
                    intr_html+=
                        `<div class="video-title">
                                <i class="fa fa-video-camera text-c2"></i>
                                <span>${videos_detail.data.create_time}</span>
                            </div>
                            <div class="video-body">
                                <h4 class="text-c2 semi-bold">${videos_detail.data.name}</h4>
                                <span>${videos_detail.data.describe}</span><br>
                                <!-- 访问量 -->
                                <div class="overall">
                                    <h6 class="text-c3">Overall Visits</h6>
                                    <h5 class="text-c2">${videos_detail.data.views}</h5>
                                    <p><i class="fa fa-play text-error"></i></p>
                                </div>
                                <!-- 评论数 -->
                                <div class="overall pull-right">
                                    <h6 class="text-c3">Comment</h6>
                                    <h5 class="text-c2">${videos_detail.data.message_count}</h5>
                                    <p><i class="fa fa-comments text-info"></i></p>
                                </div>
                            </div>`;
                    $('.video-intr').html(intr_html);
                }
            });
        });
    });
    
})();
