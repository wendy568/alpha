(function () {
	$('.log').hover(function(){
        $(this).find('.log-foot').css('visibility','visible');
    },function(){
    	$(this).find('.log-foot').css('visibility','hidden');
    });

    $('.fa-close').click(function(){
        $('#logModal').removeClass('in');
        $('#editModal').removeClass('in');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').removeClass('modal-backdrop');
    });

    // 选择添加工具
    $('.dropdown-menu .link').click(function(){
        var tool_iClass=$(this).find('i').attr('class');
        var tool_pText=$(this).children('p').text();
        function initToolHtml(){
            var tool_html='';
            
            tool_html+= '<li class="module">';
            tool_html+=     '<a href="#`+tool_pText+`" role="tab" data-toggle="tab">';
            tool_html+=         '<div class="module-icon">';
            tool_html+=             '<i class="'+tool_iClass+'"></i>';
            tool_html+=         '</div>';
            tool_html+=         '<p class="text-center text-c4">'+tool_pText+'</p>';
            tool_html+=     '</a>';
            tool_html+= '</li>';

            return tool_html;
        };
        $('.toolbar>ul>li:last').before(initToolHtml());
        $(this).remove();
    });

    // synthesizing data 财经日历----------------------------------------------------------------------------
    var dateList = [];
    var weeks = ['SUN','MON','TUE','WEN','THUR','FRI','SAT'];
    function getCalendarData(firstDate,direction,fn) {
        var date = {
            left_right : direction || '',
            time_node : firstDate || ''
        };
        
        $.alpha.request_Url('post','dashboard/calendar',date,function(data){
            if(data.archive.status == 0){
                dateList = [];
                var isCurDay = false;
                $.each(data.data.calendar,function (i,item) {
                    dateList.push(i);
                    
                    // 财经日历导航
                    i = i.replace('.','-').replace('.','-');
                    var x = i;
                    var curDay = new Date(i);
                    var month = curDay.getMonth()+1 < 10 ? '0' + (curDay.getMonth()+1) : curDay.getMonth()+1;
                    var day = curDay.getDate() < 10 ? '0' + curDay.getDate() : curDay.getDate();
                    isCurDay = new Date().getDay() == curDay.getDay();
                    activeClass = isCurDay ? 'active' : '';
                    var $navBar = $('<li class="date ' + activeClass + '">' +
                                  '<div class="text-c1 small-text text-center">'+weeks[curDay.getDay()]+'</div>' +
                                  '<div class="text-c3 text-center">'+ month +'/' + day + '</div></li>');
                    $navBar.on('click',function (e) {
                        e.stopPropagation();
                        $('.calendar-tab li').removeClass('active');
                        $('.select-country .screen-b').removeClass('selected');
                        $(this).addClass('active');
                        var index = $(this).index();
                        var panels = $('.calendar-tab-content').eq(index).find('.panel');
                        var scrollTop = 0;
                        $.each(panels,function (i,panel) {
                            var isTop = $(panel).attr('data-top').split('_');
                            if(isTop[0] == 1){
                                scrollTop = isTop[1]*60;
                            }
                        });
                        $('.calendar-tab-content').hide().eq(index).show().parent().scrollTop(scrollTop);
                    });
                    $('.En-calendar .calendar-tab').append($navBar);
                  
                    // content
                    var $content = $('<div class="calendar-tab-content"></div>');
                    $.each(item,function (i,row) {
                        var important = row.Importance == 'medium' ? 'blue' : (row.Importance == 'low' ? 'green' : 'red');
                        var curTime = new Date(parseInt(row.time_en));
                        var $contentItem = $('<div class="panel" data-top="'+row.align_top+'_'+i+'">'+
                        '<div class="panel-heading">'+
                        '<p class="panel-title">'+
                        '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'+'_'+x+'_'+i+'">'+
                        '<ul class="row no-margin no-padding">'+
                        '<li class="col-sm-1">'+curTime.getHours()+':'+curTime.getMinutes()+'</li>'+
                         '<li class="col-sm-1">'+
                        '<i class="country_img ' + getFlagOfCountry(row.Currency) + '"></i>'+
                        '</li>'+
                        '<li class="col-sm-6">'+
                        '<span>'+row.Event+'</span>'+
                        '</li>'+
                        '<li class="col-sm-1">'+row.Actual+'</li>'+
                        '<li class="col-sm-1">'+row.ForecASt+'</li>'+
                        '<li class="col-sm-1">'+row.Previous+'</li>'+
                        '<li class="col-sm-1 text-right">'+
                        '<i class="status-icon '+ important +'"></i>'+
                        '</li>'+
                        '</ul>'+
                        '</a>'+
                        '</p>'+
                        '</div>'+
                        '<div id="collapse'+'_'+x+'_'+i+'" class="panel-collapse collapse">'+
                        '<div class="panel-body">'+row.detail+'</div>'+
                        '</div>'+
                        '</div>');
                        
                        $content.append($contentItem);
                    });
                    
                    isCurDay ? $content.show() : $content.hide();
                    $('#accordion').append($content);
                });
            }
            fn && fn(data);
        });
    }
    getCalendarData();
    
    $('.En-calendar .carousel-inner>a').eq(0).find('input').click(function (e) {
        e.stopPropagation();
        var $this = $(this);
        var lastDate = dateList[0].replace('.','-').replace('.','-');
        $('.En-calendar .calendar-tab').empty();
        $('.calendar-tab-content').remove();
        $this.prop('disabled',true);
        getCalendarData(parseInt((new Date(lastDate).getTime())/1000),'left',function () {
            $this.prop('disabled',false);
        });
    });
    $('.En-calendar .carousel-inner>a').eq(1).find('input').click(function (e) {
        e.stopPropagation();
        var $this = $(this);
        var lastDate = dateList[6].replace('.','-').replace('.','-');
        $('.En-calendar .calendar-tab').empty();
        $('.calendar-tab-content').remove();
        $this.prop('disabled',true);
        getCalendarData(parseInt((new Date(lastDate).getTime())/1000),'right',function () {
            $this.prop('disabled',false);
        });
    });
    
    // 筛选
    $('.select-country .screen-b').click(function (e) {
        e.stopPropagation();
        $(this).addClass('selected').siblings().removeClass('selected');
        var $news = $('#accordion .calendar-tab-content').eq($('.calendar-tab li.active').index()).children();
        var curClass = $(this).find('.country_img').attr('class');
        if($news.length){
            $.each($news,function (i,row) {
              var className = $(row).find('.country_img').attr('class');
              if(className == curClass){
                $(row).show();
              }else{
                $(row).hide();
              }
            });
        }
    });
    $('.select-country .screen-a').click(function (e) {
        e.stopPropagation();
        $(this).siblings().removeClass('selected');
        $('#accordion .calendar-tab-content').eq($('.calendar-tab li.active').index()).children().show();
    });

    //news--------------------------------------------------------------------------
	function getNewsData(firstDate,direction,fn){
		var date = {
            left_right : direction || '',
            time_node : firstDate || ''
        };
    	$.alpha.request_Url('post','Utility/week_news',date,function(data){
    		if(data.archive.status == 0){
    			dateList = [];
                var isCurDay = false;
                $.each(data.data.news,function (i,item) {
                    dateList.push(i);
                    
                    i = i.replace('.','-').replace('.','-');
                    var x = i;
                    var curDay = new Date(i);
                    var month = curDay.getMonth()+1 < 10 ? '0' + (curDay.getMonth()+1) : curDay.getMonth()+1;
                    var day = curDay.getDate() < 10 ? '0' + curDay.getDate() : curDay.getDate();
                    isCurDay = new Date().getDay() == curDay.getDay();
                    activeClass = isCurDay ? 'active' : '';
                    var $navBar = $('<li class="date ' + activeClass + '">' +
                                  '<div class="text-c1 small-text text-center">'+weeks[curDay.getDay()]+'</div>' +
                                  '<div class="text-c3 text-center">'+ month +'/' + day + '</div></li>');
                    $navBar.on('click',function (e) {
                        e.stopPropagation();
                        $('.news-tab li').removeClass('active');
                        $(this).addClass('active');
                        var index = $(this).index();
                        
                        $('.news-tab-content').hide().eq(index).show();
                    });
                    $('.En-news .news-tab').append($navBar);

                    // content
                    var oneUl=Math.ceil(item.length/2);
                    var $content = $('<div class="news-tab-content"></div>');
                    var $leftContent = $('<div class="col-sm-12 col-md-6 newsLeft"></div>');
                    var $rightContent = $('<div class="col-sm-12 col-md-6 newsRight"></div>');
                    var $contentItem_left = $('<ul class="cbp_tmtimeline"></ul>');
                    var $contentItem_right = $('<ul class="cbp_tmtimeline"></ul>');
                    var leftItem = '', rightItem = '';
                    $.each(item,function(i,data){
                    	var newDate=new Date();
		                newDate.setTime(data.time * 1000);
		                var newsTime=newDate.toTimeString().substring(0,5);
		                if(i<oneUl){
		                	leftItem += '<li class="panel">' +
                                        '<div class="panel-heading">' +
                                            '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'+ i +'">' +
                                                '<time class="cbp_tmtime" datetime="18:30">' +
                                                    '<span class="time">'+ newsTime +'</span>' +
                                                '</time>' +
                                                '<div class="cbp_tmicon primary animated bounceIn"> <i class="fa fa-circle-o text-c3"></i> </div>' +
                                                '<div class="cbp_tmlabel">' +
                                                    '<div class="p-l-10 p-r-10 xs-p-r-10 xs-p-l-10 xs-p-t-5">' +
                                                        '<p class="m-t-5 text-c2">' + data.title + '</p>' +
                                                    '</div>' +
                                                    '<div class="clearfix"></div>' +
                                                '</div>' +
                                            '</a>' +
                                        '</div>' +
                                        '<div id="collapse'+ i +'" class="panel-collapse collapse">' +
                                             '<div class="panel-body">'+ data.desc +'</div>' +
                                        '</div>' +
                                    '</li>' ;
		                }else{
		                	rightItem += '<li class="panel">' +
                                '<div class="panel-heading">' +
                                    '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'+ i +'">' +
                                        '<time class="cbp_tmtime" datetime="18:30">' +
                                            '<span class="time">'+ newsTime +'</span>' +
                                        '</time>' +
                                        '<div class="cbp_tmicon primary animated bounceIn"> <i class="fa fa-circle-o text-c3"></i> </div>' +
                                        '<div class="cbp_tmlabel">' +
                                            '<div class="p-l-10 p-r-10 xs-p-r-10 xs-p-l-10 xs-p-t-5">' +
                                                '<p class="m-t-5 text-c2">' + data.title + '</p>' +
                                            '</div>' +
                                            '<div class="clearfix"></div>' +
                                        '</div>' +
                                    '</a>' +
                                '</div>' +
                                '<div id="collapse'+ i +'" class="panel-collapse collapse">' +
                                     '<div class="panel-body">'+ data.desc +'</div>' +
                                '</div>' +
                            '</li>';
		                }
                    });
                    $content.append($leftContent.append($contentItem_left.html(leftItem)));
                    $content.append($rightContent.append($contentItem_right.html(rightItem)));
                    isCurDay ? $content.show() : $content.hide();
                	$('#newsContent').append($content);
                });
    		}
    		fn && fn(data);
    	});
	}
	getNewsData();

	$('.En-news .carousel-inner>a').eq(0).find('input').click(function (e) {
        e.stopPropagation();
        var $this = $(this);
        var lastDate = dateList[0].replace('.','-').replace('.','-');
        $('.En-news .news-tab').empty();
        $('.news-tab-content').remove();
        getNewsData(parseInt((new Date(lastDate).getTime())/1000),'left',function(){
        	$this.prop('disabled',false);
        });
    });
    $('.En-news .carousel-inner>a').eq(1).find('input').click(function (e) {
        e.stopPropagation();
        var $this = $(this);
        var lastDate = dateList[6].replace('.','-').replace('.','-');
        $('.En-news .news-tab').empty();
        $('.news-tab-content').remove();
        getNewsData(parseInt((new Date(lastDate).getTime())/1000),'right',function(){
        	$this.prop('disabled',false);
        });
    });
  
  	// log-----------------------------------------------------------------------------
	function getLogData(firstDate,direction,fn){
		var date = {
            left_right : direction || '',
            time_node : firstDate || ''
        };
        // logList
  		$.alpha.request_Url('post','Utility/tradingLogList',date,function(data){
  			if(data.archive.status == 0){
    			dateList = [];
                var isCurDay = false;
                // overall
                $('.pull-left .text-success').html(data.data.OverAll);

                $.each(data.data.trading_logs,function (i,item) {
                    dateList.push(i);
                    
                    i = i.replace('.','-').replace('.','-');
                    var x = i;
                    var curDay = new Date(i);
                    var month = curDay.getMonth()+1 < 10 ? '0' + (curDay.getMonth()+1) : curDay.getMonth()+1;
                    var day = curDay.getDate() < 10 ? '0' + curDay.getDate() : curDay.getDate();
                    isCurDay = new Date().getDay() == curDay.getDay();
                    activeClass = isCurDay ? 'active' : '';
                    var $navBar = $('<li class="date ' + activeClass + '">' +
                                  '<div class="text-c1 small-text text-center">'+weeks[curDay.getDay()]+'</div>' +
                                  '<div class="text-c3 text-center">'+ month +'/' + day + '</div></li>');
                    $navBar.on('click',function (e) {
                        e.stopPropagation();
                        $('.log-tab li').removeClass('active');
                        $(this).addClass('active');
                        var index = $(this).index();
                        
                        $('.log-tab-content').hide().eq(index).show();
                    });
                    $('.En-log .log-tab').append($navBar);

                    // content
                    var $content = $('<div class="log-tab-content"></div>');
                    var log_html='';
                    $.each(item,function(i,data){
                    	if(data.color == "red"){
                    		titleImg='src="assets/img/log_bg_01.png"';
                    	}else if(data.color == "yellow"){
                    		titleImg='src="assets/img/log_bg_02.png"';
                    	}else if(data.color == "blue"){
                    		titleImg='src="assets/img/log_bg_03.png"';
                    	};

                    	log_html =
                    	$('<div class="col-lg-4 m-b-40">'+
                            '<div id="'+ data.id +'" class="log">'+
                                '<img '+ titleImg +'" alt="" class="log-title">'+
                                '<div class="log-body ">'+
                                    '<h3>'+
                                    	'<i class="status-icon '+ data.color +'"></i>'+ data.title +
                                    '</h3>'+
                                    '<p class="log-data">'+
                                        '<i class="fa fa-clock-o"></i>'+
                                       '<span class="m-l-5">'+ data.update_time +'</span>'+
                                    '</p>'+
                                    '<p class="log-content">'+ data.content +'</p>'+
                                '</div>'+
                                '<div class="log-foot">'+
                                    '<p class="text-center logEdit" data-toggle="modal" data-target="#logModal" style="cursor:pointer;">'+
                                        '<i class="fa fa-edit"></i>'+
                                        '<a class="m-l-5 text-c3">Edit</a>'+
                                    '</p>'+
                                '</div>'+
                            '</div>'+
                        '</div>');

                        $(log_html).find('.logEdit').click(function(){
                            var id = data.id;
                            var title = data.title;
                            var content = data.content;
                            var color = data.color;
                            $('.form-control[name="title"]').val(title);
                            $('[name="content"]').val(content);
                            $('#logModal').attr('data-logId',id);
                        });
                    	$content.append(log_html);
                    });
                    
                    isCurDay ? $content.show() : $content.hide();
                   	$('.logList').append($content);
                });
    		}
    		fn && fn(data);
  		});
	}
	getLogData();

	$('.En-log .carousel-inner>a').eq(0).find('input').click(function (e) {
        e.stopPropagation();
        var $this = $(this);
        var lastDate = dateList[0].replace('.','-').replace('.','-');
        $('.En-log .log-tab').empty();
        $('.log-tab-content').remove();
        getLogData(parseInt((new Date(lastDate).getTime())/1000),'left',function(){
        	$this.prop('disabled',false);
        });
    });
    $('.En-log .carousel-inner>a').eq(1).find('input').click(function (e) {
        e.stopPropagation();
        var $this = $(this);
        var lastDate = dateList[6].replace('.','-').replace('.','-');
        $('.En-log .log-tab').empty();
        $('.log-tab-content').remove();
        getLogData(parseInt((new Date(lastDate).getTime())/1000),'right',function(){
        	$this.prop('disabled',false);
        });
    });

    // logAdd-----------------------------------------------------------------------------
    // var titleReg=/^[\u4E00-\u9FA5A-Za-z0-9]{2,20}$/;	
    // var contentReg=/^[\u4E00-\u9FA5A-Za-z0-9]{10,500}$/;	

    // $('[name="title"]').change(function () {
    //     if(titleReg.test($(this).val())){
    //         $.alpha.props($(this).parent(),'none');
    //     }else{
    //         $.alpha.props($(this).parent(),'right','Please enter 2-20 characters!');
    //     }
    // });
    // $('[name="content"]').change(function () {
    //     if(contentReg.test($(this).val())){
    //         $.alpha.props($(this).parent(),'none');
    //     }else{
    //         $.alpha.props($(this).parent(),'right','Please enter at least 10 characters!');
    //     }
    // });

    $('.submit').click(function(){
    	var title=$('.form-control[name="title"]').val();
    	var content=$('[name="content"]').val();
        var color = $('[name="color"]').val();
        var logId=$('#logModal').attr('data-logId');
    	var data={
    		title : title,
    		content : content,
            color : color
    	}
    	if(title && content){
            // 新增
            if(!logId){
    	    	$.alpha.request_Url('post','Utility/addTradingLog',data,function(res){
    	    		if(res.archive.status == 0){
    	    			$.alpha.notification('success','Add Success');

    	    		}else{
    	    			$.alpha.alertBox('Fail','Add Failed');
    	    		}
    	    	});
            }else{
            // 修改
                data.id=logId;
                $.alpha.request_Url('post','Utility/updateTradingLog',data,function(res){
                    if(res.archive.status == 0){
                        $.alpha.notification('success','Update Success');
                        // 更新页面数据
                        $('.logList #'+logId).find('h3').html('<i class="status-icon '+ color +'"></i>'+ title);
                        $('.logList #'+logId).find('.log-content').html(content);
                        $('#logModal').hide();
                        $('.modal-backdrop').removeClass('in');
                        $('body').removeClass('.modal-open');
                    }else{
                        $.alpha.alertBox('Fail','Update Failed');
                    }
                });
            }
    	}else{
    		if(!title){
    			$.alpha.props($('.form-control[name="title"]').parent(),'right','Not Empty!');
    		}
    		if(!content){
    			$.alpha.props($('[name="content"]').parent(),'right','Not Empty!');
    		}
    	}
    });


	function getFlagOfCountry(country) {
	    var countryClass = '';
	    if(country == 'New Zealand'){
	      countryClass = 'country_nzd';
	    }
	    else if(country == 'Japan'){
	      countryClass = 'country_jpy';
	    }
	    else if(country == 'China'){
	      countryClass = 'country_cny';
	    }
	    else if(country == 'the United States'){
	      countryClass = 'country_usd';
	    }
	    else if(country == 'the United Kingdom'){
	      countryClass = 'country_gbp';
	    }
	    else if(country == 'Australia'){
	      countryClass = 'country_aud';
	    }
	    else if(country == 'Euro'){
	      countryClass = 'country_eur';
	    }
	    else if(country == 'Switzerland'){
	      countryClass = 'country_chf';
	    }
	    return countryClass;
	}
})();
