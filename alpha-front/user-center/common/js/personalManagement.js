(function () {
    var curStage = 0;

    // 环形进度条JS
    function getStage(stage) {
        var c1 = document.getElementById('c1');
        var ctx = c1.getContext('2d');
        ctx.lineWidth = 10;
        ctx.font = '60px SimHei';
        ctx.textBaseline = 'top';
        
        var percent = stage;
        // var deg=0;
        var timer = setInterval(function () {
            //清除所有内容
            ctx.clearRect(0, 0, 260, 260);
            
            //绘制外层灰色框
            ctx.beginPath();
            ctx.arc(130, 130, 80, 0, 2 * Math.PI);
            ctx.strokeStyle = 'rgba(225,225,225,.2)';
            ctx.stroke();
            
            //绘制圆拱形进度条
            ctx.beginPath();
            var progress = 2 * Math.PI / 15 * percent;
            ctx.arc(130, 130, 80, 0 - Math.PI / 2, progress - Math.PI / 2);
            ctx.strokeStyle = '#fff';
            ctx.stroke();
            
            //绘制进度提示文字
            var txt = percent;
            var w = ctx.measureText(txt).width;
            ctx.fillText(txt, 130 - w / 2, 130 - 30);
            ctx.fillStyle = '#fff';
        }, 50);
    }
    
    // // 横向拖拽
    // $(".roll-list").on({
    //     click: function (e) {
    //         var event = e || window.event;
    //         event.stopPropagation();
    //     },
    //     mousedown: function(e){
    //         var el=$(this);
    //         var os = el.offset(), dx = e.pageX-os.left;
    //         $(document).on('mousemove.drag', function(e){ el.offset({left: e.pageX-dx}); });
    //     },
    //     mouseup: function(e){
    //         $(document).off('mousemove.drag');
    //         var _this = $(this);
    //         setTimeout(function () {
    //             var maxLeft = parseInt(_this.parent().width()) - parseInt(_this.width());
    //             if (parseInt(_this.css('left')) >=0){
    //                 _this.animate({'left':0});
    //             }
    //             if (parseInt(_this.css('left')) <= maxLeft){
    //                 _this.animate({'left':maxLeft + 'px'});
    //             }
    //         })
    //     }
    // });
    
    // 关闭tvModal
    $('#tvModal').on('hide.bs.modal', function () {
        $('#tvModal .tv-detail-header').empty();
    });
    // 关闭articModal
    $('#articleModal').on('hide.bs.modal', function () {
        $('#articleModal .tv-detail-body').empty();
    });
    
    $('.course-nav span').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        var index = $(this).index() > 0 ? 1 : 0;
        $(this).addClass('actived').siblings('span').removeClass('actived');
        $('.page-content .course').eq(index).addClass('show').siblings('.course').removeClass('show');
    })
    
    // 获取videolist
    function getVideoList(videoList) {
        var tvList = "";
        $('.tv-list').empty();
        if (videoList.length) {
            $.each(videoList, function (i, data) {
                tvList = $('<li id="' + data.id + '" class="tv-small col-lg-4 col-md-4 col-sm-6 col-xs-12 no-margin m-b-30" data-toggle="modal" data-target="#tvModal">' +
                    '<div class="bk-img">' +
                    '<img src="' + alpha_host + 'upload/' + data.image[0] + 'm_' + data.image[1] + '" alt="" >' +
                    '</div>' +
                    '<img class="tv-btn img-responsive" src="./assets/img/dashboard_tv_play.png" alt="">' +
                    '<div class="tv-des">' +
                    '<h5 class="text-c2">' + data.name + '</h5>' +
                    '</div>' +
                    '</li>');
                $('.tv-list').append(tvList);
            });
            $('.tv-list').on('click', '.tv-small', function () {
                var vmid = $(this).attr('id');
                $.alpha.request_Url('post', 'Classes/record_process', {
                    article_classes_id: vmid,
                    look_up: 'video'
                }, function (data) {
                });
                $.alpha.request_Url('post', 'video/videos_detail', {class_id: vmid}, function (data) {
                    var tvStudy = "";
                    tvStudy += '<iframe id="tv" src="http://content.jwplatform.com/players/' + data.data.source + '-T351KaXB.html" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>';
                    $('#tvModal .tv-detail-header').html(tvStudy);
                    var tvdesc = "";
                    tvdesc += '<h3 class="text-c1 no-margin p-b-10">' + data.data.name + '</h3><P class="text-c3 no-padding">' + data.data.describe + '</P>';
                    $('#tvModal .tv-detail-body').html(tvdesc);
                });
            });
        }
    }
    
    // 获取articlelist
    function getArticleList(articleList) {
        var articList = "";
        $('.artic-list').empty();
        if (articleList.length) {
            $.each(articleList, function (i, data) {
                articList = $('<li id="' + data.id + '" class="tv-small col-lg-4 col-md-4 col-sm-6 col-xs-12 no-margin m-b-30" data-toggle="modal" data-target="#articleModal">' +
                    '<div class="bk-img">' +
                    '<img src="' + alpha_host + 'upload/' + data.image[0] + 'm_' + data.image[1] + '" alt="" >' +
                    '</div>' +
                    '<div class="tv-des">' +
                    '<h5 class="text-c2">' + data.title + '</h5>' +
                    '</div>' +
                    '</li>');
                $('.artic-list').append(articList);
            });
            $('.artic-list').on('click', '.tv-small', function () {
                var aid = $(this).attr('id');
                $.alpha.request_Url('post', 'Classes/article_detail', {article_id: aid}, function (data) {
                    var artdesc = "";
                    artdesc += ['<div class="text-c1 tv-close close" data-dismiss="modal" style="top:0;opacity: 1;">X</div>',
                        '<h3 class="text-c1 no-margin p-b-10">',
                        '<i class="status-icon yellow m-r-10 m-b-5"></i>',
                        data.data.title + '</h3>',
                        '<p>' + data.data.update_time + '</p>',
                        '<P class="text-c3 no-padding">' + data.data.content + '</P>'].join('');
                    $('#articleModal .tv-detail-body').html(artdesc);
                });
            });
        }
    }
    
    //  获取课程内容
    function getStudyList(stage, stageDtail, complete) {
        var content = '';
        for (var i in stageDtail) {
            if (typeof(stageDtail[i]) == 'string' || typeof(stageDtail[i]) == 'number') {
                stageDtail[i] = stageDtail[i] + '';
                content = curStage == stage ? stageDtail[i].split('/')[0] : (stage > curStage ? 0 : stageDtail[i]);
            }
            var index = i;
            var isComplete = 'fa fa-circle-o text-c3';
            if (stage < curStage) {
                isComplete = 'complete';
            } else if (stage > curStage) {
                isComplete = 'fa fa-circle-o text-c3';
            } else {
                isComplete = (complete && complete[i]) ? 'complete' : 'fa fa-circle-o text-c3';
            }
            var setComplete = function (name) {
                $('#stage' + stage + name).html(content);
                $('#stage' + stage + name).parents('li.panel').find('i').attr('class', isComplete);
            };
            switch (i.toLocaleLowerCase()) {
                case 'video learning':
                    getVideoList(stageDtail[index]);
                    $('#stage' + stage + ' .tv-list').parents('li.panel').find('i').attr('class', isComplete);
                    break;
                case 'article learning':
                    getArticleList(stageDtail[index]);
                    $('#stage' + stage + ' .artic-list').parents('li.panel').find('i').attr('class', isComplete);
                    break;
                case 'place your order':
                    setComplete(' .placeYourOrder');
                    break;
                case '4 style trade':
                    setComplete(' .4StyleTrade');
                    break;
                case 'take profits/stop loss':
                    setComplete(' .stopLoss');
                    break;
                case 'make transactions':
                    setComplete(' .makeTransactions');
                    break;
                case 'trade all kinds products':
                    setComplete(' .tradeAllKindsProducts');
                    break;
                case 'trading record':
                    setComplete(' .tradingRecord');
                    break;
                case 'learning report':
                    setComplete(' .learningReport');
                    break;
                case 'make transaction 1':
                    setComplete(' .makeTransactionOn');
                    break;
                case 'make transaction 2':
                    setComplete(' .makeTransactionTwo');
                    break;
                case 'task 1 - 2 different markets':
                    setComplete(' .2DifferentMarkets');
                    break;
                case 'task 2 - 10 different products':
                    setComplete(' .10DifferentProducts');
                    break;
                case '5 tradable products':
                    setComplete(' .5TradableProducts');
                    break;
                case 'produce a module':
                    setComplete(' .produceAModule');
                    break;
                case 'risk management level':
                    setComplete(' .riskManagementLevel');
                    break;
                case 'trading score':
                    setComplete(' .tradingScore');
                    break;
                case 'profitable period':
                    setComplete(' .profitablePeriod');
                    break;
            }
        }
    }
    
    function getCurStage() {
        $.alpha.request_Url('post', 'Classes/current_stage', {}, function (data) {
            // 阶段展示
            var stage = curStage = data.data.current_stage;
            getStage(stage);
            if (stage > 8) {
                $('#levelList').scrollLeft(stage * 147);
                $('.scroller-bar').css('left',$('#levelList').scrollLeft());
            }
            // 完成情况
            var complete = data.data.complete;
            $('.description span').html(complete * 100 + '%');
            $('.stage-left .progress').html('<div class="progress-bar progress-bar-success animate-progress-bar" data-percentage="' + complete * 100 + '%" style="width:' + complete * 100 + '%"></div>');
            
            // title
            $('.pro-intr h4').html(data.data.title);
            
            // 阶段描述点击获取全文
            var desc = data.data.describe.substr(0, 80);
            var i = 0;
            $('.more').html('Continue Reading...');
            $('.more').click(function () {
                if (i == 0) {
                    desc = data.data.describe;
                    $(this).html('Pack Up The Full...');
                    i = i + 1;
                } else {
                    desc = data.data.describe.substr(0, 80);
                    $(this).html('Continue Reading...');
                    i = 0;
                }
                $('.pro-intr p').html(desc);
            });
            $('.pro-intr p').html(desc);
            
            // 定位 stage learning
            $('.roll-list li').removeClass('active').eq(stage - 1).addClass('active');
            $('.tab-pane').removeClass('active').eq(stage - 1).addClass('active');
            
            // 获取课程内容
            var stageDtail = data.data.detail;
            getStudyList(stage, stageDtail, data.data.is_complete);
        });
    }
    
    getCurStage();
    
    $('.module').click(function () {
        var stage_id = parseInt($(this).index()) + 1;
        if (stage_id != curStage) {
            $.alpha.request_Url('post', 'Classes/showStageDetail', {stage_id: stage_id}, function (data) {
                
                // title
                $('.pro-intr h4').html(data.data.title);
                
                // 阶段描述点击获取全文
                var desc = data.data.describe.substr(0, 80);
                var i = 0;
                $('.more').html('Continue Reading...');
                $('.more').click(function () {
                    if (i == 0) {
                        desc = data.data.describe;
                        $(this).html('Pack Up The Full...');
                        i = i + 1;
                    } else {
                        desc = data.data.describe.substr(0, 80);
                        $(this).html('Continue Reading...');
                        i = 0;
                    }
                    $('.pro-intr p').html(desc);
                });
                $('.pro-intr p').html(desc);
                
                var stageDtail = data.data.detail;
                getStudyList(stage_id, stageDtail);
            });
        } else {
            getCurStage();
        }
        
        // 自动定位
        var liList = $(this).parent();
        var offLeft = $(this).offset().left - liList.offset().left + parseInt(liList.css('left'));
        var offWidth = parseInt(liList.parent().width());
        var left = parseInt(liList.css('left'));
        var maxLeft = parseInt(liList.parent().width()) - parseInt(liList.width());
        var actLeft = 0;
        
        if (offLeft - 60 > offWidth/2){
            actLeft = left + (offWidth/2 - offLeft) + 60;
            if (actLeft <= maxLeft){
                liList.animate({'left':maxLeft + 'px'});
            }
            else {
                liList.animate({'left': actLeft + 'px'});
            }
        }
        else if (offLeft + 60 < offWidth/2){
            actLeft = left + (offWidth/2 - offLeft -60);
            if (actLeft >=0){
                liList.animate({'left':0});
            }
            else{
                liList.animate({'left': actLeft + 'px'});
            }
            
        }
    });
    
    /*------------------------------课程管理---------------------------------------*/

    var timeLine = ['08:00-09:30', '10:00-11:30', '13:00-14:30', '15:00-16:30', '17:00-18:30', '21:00-22:30'];
    var week = 0;
    getCourseList(week);
    $('.week-count').html(week);

    $('.coursed .weekSelect').click(function(e){
        if($(this).html().indexOf('pre') > -1){
            week--;
        }else{
            week++;
        }
        getCourseList(week);
        $('.week-count').html(week);
    });

    function getCourseList(week){
        $.alpha.request_Url('post','course/my_course', {week:week || ''}, function(res){
            var course = res.data;
            var list = [];
            var index = 0;
            $('.coursed .learn').html('');
            $('.coursed .dates').html('');

            for (var i in course){
                $('.coursed .dates').eq(index).html(i);
                for (var j in course[i]){
                    list = list.concat(course[i][j]);
                }
                index++;
            }

            for (var x in list){
                var day = list[x].the_day;
                var time_zone = 0;
                var isChecked = list[x].is_special;
                for (var j in timeLine){
                    if(timeLine[j] == list[x].time_zone){
                        time_zone = parseInt(j) + 1;
                    }
                }
                var $course = $('<div class="p-t-10 p-b-10 p-l-10 text-left" data-special="'+list[x].special+'">'+
                                '<input type="checkbox" name="learn_'+time_zone+'-'+day+'" style="vertical-align:middle"/>'+
                                '<span class="m-l-5 name">'+list[x].course+'</span><span class="m-l-5 name">('+list[x].teacher+')</span></div>');
                
                $course.css('color', isChecked ? '#fff' : 'inherit');
                isChecked ? $course.find('input').prop('checked',true) : '';

                $course.find('input').on('click',function(e){
                    var event = e || window.event;
                    event.stopPropagation();
                    var ischeck = $(this).prop('checked');
                    var special = $(this).parent().attr('data-special');
                    var $curCourse = $(this).parent().parent('td').find('div[data-special]');
                    $.each($curCourse,function(index,item){
                        var lastCheck = $(item).find('input').prop('checked');
                        $(item).css('color', 'inherit');
                        if(lastCheck && (special != $(item).attr('data-special'))){
                            $.alpha.request_Url('post','course/pickUpCourse', {special:$(item).attr('data-special')}, function(res){},window.alpha_host_new);
                        }
                    });
                    $(this).parent().parent('td').find('input').prop('checked',false);
                    $(this).prop('checked',ischeck);
                    ischeck ? $(this).parent().css('color', '#fff') : $(this).parent().css('color', 'inherit');
                    $.alpha.request_Url('post','course/pickUpCourse', {special:special}, function(res){},window.alpha_host_new);
                })
                $('.coursed .learn_' + time_zone + '-' + day).append($course);
            }
        }, window.alpha_host_new);
    }
})();
