(function () {
	$('.log').hover(function(){
        $(this).children('.log-foot').toggleClass('hide');
    });

    $('.fa-close').click(function(){
        $('#logModal').removeClass('in');
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
    $('.module').eq(1).click(function(){
    	var dateList = [];
    	var weeks = ['SUN','MON','TUE','WEN','THUR','FRI','SAT'];
    	function getNewsData(firstDate,direction,fn){
    		var date = {
	            left_right : direction || '',
	            time_node : firstDate || ''
	        };
	    	$.alpha.request_Url('post','Utility/week_news',date,function(data){
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
	                    $.each(data.data.news,function(i,data){
	                    
	                    });
	                });
	    		}
	    		fn && fn(data);
	    	});
    	}
    	getNewsData();
    	$('.En-calendar .carousel-inner>a').eq(0).click(function (e) {
	        e.stopPropagation();
	        var lastDate = dateList[0].replace('.','-').replace('.','-');
	        $('.En-calendar .calendar-tab').empty();
	        $('.calendar-tab-content').remove();
	        getCalendarData(parseInt((new Date(lastDate).getTime())/1000),'left');
	    });
	    $('.En-calendar .carousel-inner>a').eq(1).click(function (e) {
	        e.stopPropagation();
	        var lastDate = dateList[6].replace('.','-').replace('.','-');
	        $('.En-calendar .calendar-tab').empty();
	        $('.calendar-tab-content').remove();
	        getCalendarData(parseInt((new Date(lastDate).getTime())/1000),'right');
	    });
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
