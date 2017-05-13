(function () {
    // description 首页正文卡片数据栏--------------------------------------------------------
    $.alpha.request_Url('post','dashboard/previews_since_today',{},function (data) {
      if(data.archive.status == 0){
        var avgHoldTimeOfH = Math.floor(data.data.avg_holding_time/60/60);
        var avgHoldTimeOfM = Math.ceil((data.data.avg_holding_time - avgHoldTimeOfH * 3600)/60);
        avgHoldTimeOfM = avgHoldTimeOfM > 60 ? (avgHoldTimeOfM - 60 && avgHoldTimeOfH + 1) : avgHoldTimeOfM;
        var avgHoldTime = (avgHoldTimeOfH > 1 ? avgHoldTimeOfH + 'H' : '') + (avgHoldTimeOfM > 0 && avgHoldTimeOfM < 60 ? avgHoldTimeOfM + 'M' : '');

        var transactionPeroid= Math.floor(data.data.transaction_peroid/60/60/24) ;

        $('.card .animate-number').eq(0).html(data.data.trading_count);
        $('.card .animate-number').eq(1).html(data.data.profit);
        $('.card .animate-number').eq(2).html(avgHoldTime);
        $('.card .animate-number').eq(3).html(transactionPeroid);

        $('.hight').eq(0).html(data.data.last_trading_count);
        $('.hight').eq(1).html(data.data.last_profit);
        $('.hight').eq(2).html(data.data.last_avg_holding_time);
        $('.hight').eq(3).html(data.data.last_transaction_peroid);
      }
    });

    //折线图
    $.alpha.request_Url('post','dashboard/profit_statistics',{},function(data){
        if(data.archive.status == 0){
            var date=data.data.profit_week;
            var key=[];
            var currData=[];

            for(var i in date){
                key.push(i);
                var cur = 0;
                cur = !date[i] ? 0 : date[i];
                currData.push(cur);
            }

            var lineChart = echarts.init(document.getElementById('lineChart'),'purple-passion');
            var option = {
                title: {},
                tooltip : {
                    trigger: 'axis',
                    axisPointer: {
                      type: 'cross',
                      label: {
                        backgroundColor: '#6a7985',
                      }
                    }
                },
                legend: {},
                toolbox: {
                    feature: {
                      saveAsImage: {}
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true,
                    height:260
                },
                xAxis: [
                    {
                      type : 'category',
                      boundaryGap : false,
                      data : key,
                      textStyle : {
                        color: '#fff'
                      },
                    }
                ],
                yAxis : [
                    {
                      type : 'value'
                    }
                ],
                series : [
                    {
                      name:'profit',
                      type:'line',
                      areaStyle: {normal: {}},
                      data:currData
                    },

                ]
            };
            // 使用刚指定的配置项和数据显示图表。
            lineChart.setOption(option);
        }
    });


    // synthesizing data 条形图----------------------------------------------------------------------------
    $.alpha.request_Url('post','dashboard/trading_evaluating',{},function(data){
      if(data.archive.status == 0){
        $('.chart .label-important').eq(0).html(data.data.risk_management_level);
        $('.chart .label-important').eq(1).html(data.data.operating_frequecy);
        $('.chart .label-info').eq(0).html(data.data.operating_accuracy);
        $('.chart .label-info').eq(1).html(data.data.trading_ability);
      }
    });


    // synthesizing data 环形图----------------------------------------------------------------------------
    var billCount = ['AUD/USD','EUR/USD','GBP/USD','NZD/USD','USD/CAD','USD/CHF','USD/CNH','USD/JPY',
      'AUD/CAD','AUD/CHF','AUD/JPY','AUD/NZD','CAD/CHF','CAD/JPY','CHF/JPY','EUR/AUD','EUR/CAD','EUR/CHF',
      'EUR/GBP','EUR/JPY','EUR/NZD','GBP/AUD','GBP/CAD','GBP/CHF','GBP/JPY','GBP/NZD','NZD/JPY','GOLD',
      'AUG','DXY','COPPER','NGAS','UKOIL','USOIL','AUS200','HKG50','HKH40','JPN225','NAS100',
      'SPX500','UK100','US30'];
    var pieChart = echarts.init(document.getElementById('ram-usage'),'purple-passion');
    
    function getPieData(bill) {
        bill = bill.replace('/','');
        $.alpha.request_Url('post','dashboard/long_short_ratio',{finency_proc:bill},function(data){
            if(data.archive.status == 0){
                var billData = [];
                billData[0] = {name:'BUY',value:data.data.percent_ratio._0 * 100};
                billData[1] = {name:'SELL',value:data.data.percent_ratio._1 * 100};
                
                pieChart.setOption({
                  tooltip: {
                    trigger: 'item',
                    formatter: "{b}: {d}%"
                  },
                  series: [
                    {
                      name:'bill',
                      type:'pie',
                      radius: ['50%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        normal: {
                          show: false,
                          position: 'center'
                        },
                        emphasis: {
                          show: true,
                          textStyle: {
                            fontSize: '16',
                            fontWeight: 'bold'
                          }
                        }
                      },
                      labelLine: {
                        normal: {
                          show: false
                        }
                      },
                      data:billData
                    }
                  ]
                });
            }
        });
    }

    getPieData($('.yun span').text());

    $('.yun i').eq(0).click(function (e) {
        e.stopPropagation();
        var curBillType = $('.yun span').text();
        var curIndex = billCount.indexOf(curBillType);
        var preIndex = curIndex <= 0 ? 0 : curIndex - 1;
        getPieData(billCount[preIndex]);
        $('.yun span').text(billCount[preIndex]);
    });

    $('.yun i').eq(1).click(function (e) {
        e.stopPropagation();
        var curBillType = $('.yun span').text();
        var curIndex = billCount.indexOf(curBillType);
        var preIndex = curIndex >= billCount.length - 1 ? (billCount.length - 1) : curIndex + 1;
        getPieData(billCount[preIndex]);
        $('.yun span').text(billCount[preIndex]);
    });


    // synthesizing data 财经日历----------------------------------------------------------------------------
    var dateList = [];
    var weeks = ['SUN','MON','TUE','WEN','THUR','FRI','SAT'];
    function getCalendarData(firstDate,direction) {
        var date = {
            left_right : direction || '',
            time_node : firstDate || ''
        };

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
            else{
                countryClass = 'country_eur';
            }
            return countryClass;
        }
        
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
                    $.each(item,function (i,news) {
                        var important = news.Importance == 'medium' ? 'blue' : (news.Importance == 'low' ? 'green' : 'red');
                        var curTime = new Date(parseInt(news.time_en));
                        var $contentItem = $('<div class="panel" data-top="'+news.align_top+'_'+i+'">'+
                        '<div class="panel-heading">'+
                        '<p class="panel-title">'+
                        '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'+'_'+x+'_'+i+'">'+
                        '<ul class="row no-margin no-padding">'+
                        '<li class="col-sm-1">'+curTime.getHours()+':'+curTime.getMinutes()+'</li>'+
                         '<li class="col-sm-1">'+
                        '<i class="country_img ' + getFlagOfCountry(news.Currency) + '"></i>'+
                        '</li>'+
                        '<li class="col-sm-6">'+
                        '<span>'+news.Event+'</span>'+
                        '</li>'+
                        '<li class="col-sm-1">'+news.Actual+'</li>'+
                        '<li class="col-sm-1">'+news.ForecASt+'</li>'+
                        '<li class="col-sm-1">'+news.Previous+'</li>'+
                        '<li class="col-sm-1 text-right">'+
                        '<i class="status-icon '+ important +'"></i>'+
                        '</li>'+
                        '</ul>'+
                        '</a>'+
                        '</p>'+
                        '</div>'+
                        '<div id="collapse'+'_'+x+'_'+i+'" class="panel-collapse collapse">'+
                        '<div class="panel-body">'+news.detail+'</div>'+
                        '</div>'+
                        '</div>');
                        
                        $content.append($contentItem);
                    });
                    
                    isCurDay ? $content.show() : $content.hide();
                    $('#accordion').append($content);
                });
            }
        });
    }
    getCalendarData();
    
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

    //市场资讯
    $.alpha.request_Url('post','Dashboard/news',{},function(data){
        if (data.archive.status == 0) {
            var newDate=new Date();
            newDate.setTime(data.data.date * 1000);
            var newsMon=newDate.toDateString();
            $('#newsMon').html(newsMon);

            var news_html="";

            $.each(data.data.news,function(i,data){
                var newDate=new Date();
                newDate.setTime(data.time * 1000);
                var newsTime=newDate.toTimeString().substring(0,5);

                news_html +=
                '<li class="panel">'+
                '<div class="panel-heading">'+
                '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#news'+i+'">'+
                '<time class="cbp_tmtime" datetime="18:30">'+
                '<span class="time">'+newsTime+'</span>'+
                '</time>'+
                '<div class="cbp_tmicon primary animated bounceIn"> <i class="fa fa-circle-o text-c3"></i> </div>'+
                '<div class="cbp_tmlabel">'+
                '<div class="p-l-10 p-r-10 xs-p-r-10 xs-p-l-10 xs-p-t-5">'+
                '<p class="m-t-5 text-c2">' +data.title+ '</p>'+
                '</div>'+
                '<div class="clearfix"></div>'+
                '</div></a></div>'+
                    '<div id="news'+i+'" class="panel-collapse collapse">'+
                         '<div class="panel-body">'+ data.desc+'</div></div></li>';
                $('.cbp_tmtimeline').html(news_html);
            });
        }
    });

    // 轮播数据


})();
