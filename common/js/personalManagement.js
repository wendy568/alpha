(function(){
	// 基础样式JS
	function getStage(stage) {
	    var ctx = c1.getContext('2d');
	    ctx.lineWidth = 10;
	    ctx.font = '60px SimHei';
	    ctx.textBaseline = 'top';

	    var percent=stage;
	    // var deg=0;
	    var timer = setInterval(function(){
	      	//清除所有内容
	      	ctx.clearRect(0,0, 270, 300);

	      	//绘制外层灰色框
	      	ctx.beginPath();
	      	ctx.arc(135,150, 80, 0, 2*Math.PI);
	      	ctx.strokeStyle = 'rgba(225,225,225,.2)';
	      	ctx.stroke();

	      	//绘制圆拱形进度条
	      	ctx.beginPath();
	      	var progress=2 * Math.PI / 15 * percent;
	      	ctx.arc(135, 150, 80, 0-Math.PI/2, progress-Math.PI/2);
	      	ctx.strokeStyle = '#fff';
	      	ctx.stroke();

	      	//绘制进度提示文字
	      	var txt = percent;
	      	var w = ctx.measureText(txt).width;
	      	ctx.fillText(txt, 135-w/2, 150-30);
	      	ctx.fillStyle='#fff';
	    },50);
	}
	(function($){
                $.fn.rollSlide = function(obj){
                    var $self = this,
                    orientation = obj.orientation || 'left',   //滚动方式
                    num = obj.num || 1,      //滚动数量
                    v = (typeof obj.v === 'number') ? obj.v : 0,    //滚动速度
                    minTime = (typeof obj.space === 'number') ? ((obj.space >= 100) ? obj.space : 100) : 100,    //最小间隔为 100 ms ，
                    isStart = true,
                    roll = function(ori, n, v){
                        var $ul = $self.find('.roll-list'),
                            $item = $ul.find('li'),
                            range = 0,
                            i,len = $item.length,
                            sliceItem = [],
                            cloneSliceItem = [],
                            startTime = (new Date()).getTime(),
                            //存放滚动过的 item
                            memory = function(){
                                var arr = [];

                                if(ori === 'left' || ori === 'top'){
                                    for(i = 0; i < n; i++){
                                        range += ori === 'left' ? $($item[i]).outerWidth(true) : $($item[i]).outerHeight(true); // left 取 width，top 取 height
                                        arr.push($item[i]);
                                    }
                                } else if(ori === 'right' || ori === 'bottom'){
                                    for(i = len - n; n > 0; n--, i++){
                                        range += ori === 'right' ? $($item[i]).outerWidth(true) : $($item[i]).outerHeight(true);
                                        arr.push($item[i]);
                                    }
                                }
                                return arr;
                            };

                        isStart = false;         //关闭滚动
                        sliceItem = memory();
                        cloneSliceItem = $(sliceItem).clone();
                        //判断往哪个方向移动
                        switch (ori){
                            case 'left':
                                $ul.append(cloneSliceItem);
                                $ul.animate({
                                    'left': -range + 'px'
                                },v,function(){
                                    $(this).css({'left': 0});
                                    $(sliceItem).remove();
                                    isStart = true;    //开启滚动
                                });
                                break;
                            case 'right':
                                $ul.prepend(cloneSliceItem);
                                $ul.css('left', -range + 'px');
                                $ul.animate({
                                    'left': 0
                                },v,function(){
                                    $(sliceItem).remove();
                                    isStart = true;    //开启滚动
                                });
                                break;
                        }
                    },
                    init = function(){
                        var $ul = $self.find('.roll-list'),
                            $item = $ul.find('li'),
                            len = $item.length,
                            timer;

                        num = num <= len ? num : len;   //滚动个数超过列表数，取列表数
                        if(len > 1){
                            $self.on('click', '.pre', function(){
                                if(isStart){
                                    //横向滚动
                                    if(orientation === 'left' || orientation === 'right'){
                                        roll('right', num, v);
                                    } else{           //纵向滚动
                                        roll('bottom', num, v);
                                    }
                                }
                            }).
                            on('click', '.next', function(){
                                if(isStart){
                                    //横向滚动
                                    if(orientation === 'left' || orientation === 'right'){
                                        roll('left', num, v);
                                    } else{           //纵向滚动
                                        roll('top', num, v);
                                    }
                                }
                            }).
                            hover(function(){
                                clearInterval(timer);
                            }, function(){
                                // if(isRoll){
                                //     timer = setInterval(function(){
                                //         roll(orientation, num, v);
                                //     },space);
                                // }
                            }).
                            trigger('mouseout');
                        }
                    };

                    init();
                };
            })(jQuery);

            $('#levelList').rollSlide({
                orientation: 'left',
                num: 1,
                v: 1000,
                space: 3000,
                isRoll: false
            });

	$('.tv-close').click(function(){
		$('#tvModal').hide();
		$('#articleModal').hide();
		$('.modal-backdrop').removeClass('modal-backdrop');
		$('body').removeClass('modal-open');
		$('#tvModal').removeClass('in');
		$('#articleModal').removeClass('in');
	});

	$.alpha.request_Url('post','Classes/current_stage',{},function(data){
		// 阶段展示
		var stage=data.data.current_stage;
		getStage(stage);
		// 完成情况
		var complete=data.data.complete;
		$('.description span').html(complete);
		$('.progress').html('<div class="progress-bar progress-bar-success animate-progress-bar" data-percentage="'+ complete +'%" style="width:'+ complete +'%"></div>');

		// title
		$('.pro-intr h4').html(data.data.title);
		$('.pro-intr p').html(data.data.describe);

		// 定位 stage learning
		$('.roll-list li').removeClass('active');
		$('.tab-pane').removeClass('active');
		$('.roll-list li').eq(stage-1).addClass('active');
		$('.tab-pane').eq(stage-1).addClass('active');

		// detail
		var stageDtail=data.data.detail;
		var title=[];
		var content=[];
		for(var i in stageDtail){
			title.push(i);
			content.push(stageDtail[i]);
		}
		// video
		var tvList = "";
		$.each(content[3],function(i,data){
			tvList = $('<li id="'+ data.id +'" class="tv-small" data-toggle="modal" data-target="#tvModal">'+
                            '<div class="bk-img">'+
                                '<img src="ww_edu/upload/'+ data.image[0] +'/m_'+ data.image[1] +'" alt="" style="width: 100%;">'+
                            '</div>'+
                            '<img class="tv-btn img-responsive" src="./assets/img/dashboard_tv_play.png" alt="">'+
                           	'<div class="tv-des">'+
                                '<h5 class="text-c2">'+ data.name +'</h5>'+
                            '</div>'+
                        '</li>');
			$('.tv-list').append(tvList);
		});
		$('.tv-list').on('click','.tv-small',function(){
			var vmid=$(this).attr('id');
			$.alpha.request_Url('post','video/videos_detail',{class_id:vmid},function(data){
                var tvStudy="";
                tvStudy +=
                `<iframe id="tv" src="http://content.jwplatform.com/players/${data.data.source}-T351KaXB.html" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>`;
                $('.tv-detail-header').html(tvStudy);
                var tvdesc="";
                tvdesc +=`<h3 class="text-c1 no-margin p-b-10">${data.data.name}</h3>
                           <P class="text-c3 no-padding">${data.data.describe}</P>`;
                $('#tvModal .tv-detail-body').html(tvdesc);

            });
		});
		// artic
		var articList = "";
		$.each(content[4],function(i,data){
			articList = $('<li id="'+ data.id+'" class="tv-small" data-toggle="modal" data-target="#articleModal">'+
                            '<div class="bk-img">'+
                                '<img src="assets/img/dem0_img01.png" alt="" style="width: 100%;">'+
                            '</div>'+
                            '<div class="tv-des">'+
                                '<h5 class="text-c2">'+data.title+'</h5>'+
                            '</div>'+
                        '</li>');
			$('.artic-list').append(articList);
		});
		$('.artic-list').on('click','.tv-small',function(){
			var aid=$(this).attr('id');
			$.alpha.request_Url('post','Classes/article_detail',{article_id:aid},function(data){
                
                var artdesc="";
                artdesc +=`<div class="fa fa-close text-c1 tv-close" style="top:0"></div>
                                <h3 class="text-c1 no-margin p-b-10"> 
                                    <i class="status-icon yellow m-r-10 m-b-5"></i>
                                    ${data.data.title}
                                </h3>
                                <p>${data.data.update_time}</p>
                                <P class="text-c3 no-padding">${data.data.content}</P>`;
                $('#articleModal .tv-detail-body').html(artdesc);
            });
		});

		$('.cbp_tmlabel p span').eq(0).html(content[0]);
		$('.cbp_tmlabel p span').eq(1).html(content[1]);
		$('.cbp_tmlabel p span').eq(2).html(content[2]);
	});
})();

