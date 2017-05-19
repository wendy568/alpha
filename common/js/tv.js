function loadTv(){
    $.ajax({
        type:'POST',
        url:alpha_host+'video/videos_detail',
        data:{'class_id':1},
        success:function(videos_detail){
            // 视频播放窗口
            var big_html="";
            big_html+=
            `<iframe id="tv" src="http://content.jwplatform.com/players/${videos_detail.data.source}-T351KaXB.html" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>`;
            $('.tv-preview').html(big_html);

            // 视频介绍
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

            // video-detail-btn
            var btn_html="";
            btn_html+= 
            `<span id="${videos_detail.data.id}" class="text-c1 semi-bold" data-toggle="modal" data-target="#tvModal">PLAY</span>`;
            $('.video-btn').html(btn_html);

            // 给play按钮添加监听事件
            $('.video-btn').on('click','.text-c1',function(){
                var vid=$(this).attr('id');
                $('.modal-header').html(big_html);
                $('#detail-name').html(videos_detail.data.name);
                $('#detail-describe').html(videos_detail.data.describe);

                // 请求评论信息数据
                $.ajax({
                    type:'POST',
                    url:alpha_host+'video/message_list',
                    data:{"class_id":vid,"start":0,"limit":4},
                    success:function(message_list){
                        var commend_html="";
                        $.each(message_list.data,function(data,i){
                            commend_html+=
                            `<li class="row comment">
                                <div class="col-xs-1 text-center">
                                    <img src="assets/img/profiles/c.jpg" alt="" class="favicon"> 
                                </div>
                                <div class="col-xs-11">
                                    <p class="no-margin">
                                        <span class="text-info">${i.from_name}</span>
                                        <span class="text-c3">${i.create_time}</span>
                                    </p>
                                    <p class="text-c2 no-margin">${i.content}</p>
                                </div>
                            </li>`;
                            $('.modal-body>ul').html(commend_html);
                        })
                        // 发表评论
                        $('#reply').on('click',function(){
                            var msg_content=$('#comment').val();
                            if(msg_content == "" || msg_content == null || msg_content == undefined){
                                alert("You haven't input the content!");
                                return
                            } 

                            // $.ajax({
                            //     type:'POST',
                            //     url:alpha_host+'video/reply_message_me',
                            //     data:{"class_id":vid,"token":,"mess_id":0,"content":msg_content},
                            //     success:function(){
                            //         alert('发表成功！');
                            //     },
                            //     error:function(){
                            //         alert('数据请求失败！');
                            //     }
                            // });
                        });
                    }
                });
            });
        },
        error:function(){
            alert('There are wrong oh!'); 
        }
    });
};
loadTv();

// TV list
function loadTvList(){
    $.ajax({
        type:'POST',
        url:alpha_host+'video/list',
        data:{'limit':4,'start':1},
        success:function(list){
            var list_html="";
            $.each(list.data,function(data,i){
                var li = document.createElement('li');

                $(li).addClass('col-lg-3 tv-small m-b-40')
                .hover(function() {
                    $(this).find('.tv-play').toggleClass('hide');
                    $(this).find('.tv-play').addClass('animated');
                    $(this).find('.tv-play').addClass('bounceInDown');
                })
                .html(
                    `<img src="ww_edu/upload/${i.image[0]}/m_${i.image[1]}" alt="" class="bk-img">
                    <div class="tv-date">
                        <h6 class="text-c3">${i.length}</h6>
                    </div>
                    <img class="tv-btn img-responsive" src="./assets/img/dashboard_tv_play.png" alt="">
                    <div class="tv-des">
                        <h5 class="text-c2">${i.name}</h5>
                    </div>
                    <div class="tv-play hide">
                        <div class="video-btn" id="${i.id}">
                            <span class="text-c1 semi-bold" data-toggle="modal" data-target="#tvModal">Play</span>
                        </div>
                    </div>`);

                $('.tv-content>ul').append(li);


            });
            // video list detail
            $('.tv-content>ul').on('click','.video-btn',function(){
                var vmid=$(this).attr('id');
                 $.ajax({
                    type:'POST',
                    url:alpha_host+'video/videos_detail',
                    data:{'class_id':vmid},
                    success:function(videos_detail){
                        var tv_list_html="";
                        tv_list_html+=
                        `<iframe id="tv" src="http://content.jwplatform.com/players/${videos_detail.data.source}-T351KaXB.html" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>`;
                
                        $('.modal-header').html(tv_list_html);
                        $('#detail-name').html(videos_detail.data.name);
                        $('#detail-describe').html(videos_detail.data.describe);

                        // 请求评论信息数据
                        $.ajax({
                            type:'POST',
                            url:alpha_host+'video/message_list',
                            data:{"class_id":vmid,"start":0,"limit":4},
                            success:function(message_list){
                                var commend_html="";
                                $.each(message_list.data,function(data,i){
                                    commend_html+=
                                    `<li class="row comment">
                                        <div class="col-xs-1 text-center">
                                            <img src="assets/img/profiles/c.jpg" alt="" class="favicon"> 
                                        </div>
                                        <div class="col-xs-11">
                                            <p class="no-margin">
                                                <span class="text-info">${i.from_name}</span>
                                                <span class="text-c3">${i.create_time}</span>
                                            </p>
                                            <p class="text-c2 no-margin">${i.content}</p>
                                        </div>
                                    </li>`;
                                    $('.modal-body>ul').html(commend_html);
                                })
                                // 发表评论
                                $('#reply').on('click',function(){
                                    var msg_content=$('#comment').val();
                                    if(msg_content == "" || msg_content == null || msg_content == undefined){
                                        alert("You haven't input the content!");
                                        return
                                    } 

                                    // $.ajax({
                                    //     type:'POST',
                                    //     url:alpha_host+'video/reply_message_me',
                                    //     data:{"class_id":vid,"token":,"mess_id":0,"content":msg_content},
                                    //     success:function(){
                                    //         alert('发表成功！');
                                    //     },
                                    //     error:function(){
                                    //         alert('数据请求失败！');
                                    //     }
                                    // });
                                });
                            }
                        });
                    }
                });
            });
        },
        error:function() {
            alert('There are wrong oh!');   
        }
    }); 
};
loadTvList();