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


    // synthesizing data 综合数据接口----------------------------------------------------------------------------
    $.alpha.request_Url('post','dashboard/trading_evaluating',{},function(data){
      if(data.archive.status == 0){
        $('.chart .label-important').eq(0).html(data.data.risk_management_level);
        $('.chart .label-important').eq(1).html(data.data.operating_frequecy);
        $('.chart .label-info').eq(0).html(data.data.operating_accuracy);
        $('.chart .label-info').eq(1).html(data.data.trading_ability);
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
            containLabel: true
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
              name:'profit_week',
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


    // synthesizing data 环形图----------------------------------------------------------------------------
    var billCount = ['AUD/USD','EUR/USD','GBP/USD','NZD/USD','USD/CAD','USD/CHF','USD/CNH','USD/JPY',
      'AUD/CAD','AUD/CHF','AUD/JPY','AUD/NZD','CAD/CHF','CAD/JPY','CHF/JPY','EUR/AUD','EUR/CAD','EUR/CHF',
      'EUR/GBP','EUR/JPY','EUR/NZD','GBP/AUD','GBP/CAD','GBP/CHF','GBP/JPY','GBP/NZD','NZD/JPY','GOLD',
      'AUG','DXY','COPPER','NGAS','UKOIL','USOIL','AUS200','HKG50','HKH40','JPN225','NAS100',
      'SPX500','UK100','US30'];

    var pieChart = echarts.init(document.getElementById('ram-usage'),'purple-passion');
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
                data:[]
            }
        ]
    });


    function getPieData(bill) {
        bill = bill.replace('/','');
        $.alpha.request_Url('post','dashboard/long_short_ratio',{finency_proc:bill},function(data){
            if(data.archive.status == 0){
                var billData = [];
                billData[0] = {name:'BUY',value:data.data.percent_ratio._0 * 100};
                billData[1] = {name:'SELL',value:data.data.percent_ratio._1 * 100};
                pieChart.setOption({
                    series:[{
                        name: 'bill',
                        data: billData
                    }]
                });
            }
        });
    }

    getPieData($('.yun span').text());

    $('.yun a').eq(0).click(function (e) {
        e.stopPropagation();
        var curBillType = $('.yun span').text();
        var curIndex = billCount.indexOf(curBillType);
        var preIndex = curIndex <= 0 ? 0 : curIndex - 1;
        getPieData(billCount[preIndex]);
        $('.yun span').text(billCount[preIndex]);
    });

    $('.yun a').eq(1).click(function (e) {
        e.stopPropagation();
        var curBillType = $('.yun span').text();
        var curIndex = billCount.indexOf(curBillType);
        var preIndex = curIndex >= billCount.length - 1 ? (billCount.length - 1) : curIndex + 1;
        getPieData(billCount[preIndex]);
        $('.yun span').text(billCount[preIndex]);
    });

    // synthesizing data 财经日历----------------------------------------------------------------------------
    var firstDate = 0;
    var weeks = ['SUN','MON','TUE','WEN','THUR','FRI','SAT'];
    function getCalendarData(firstDate,direction) {
      var date = {
        left_right : direction || '',
        time_node : firstDate || ''
      };
      $.alpha.request_Url('post','dashboard/calendar',date,function(data){
        if(data.archive.status == 0){

          var dateList = [];
          var html = '';
          var isCurDay = false;
          $.each(data.data.calendar,function (i,item) {
            dateList.push(i);
            i = i.replace('.','-').replace('.','-');
            var curDay = new Date(i);
            var month = curDay.getMonth()+1 < 10 ? '0' + (curDay.getMonth()+1) : curDay.getMonth()+1;
            var day = curDay.getDate() < 10 ? '0' + curDay.getDate() : curDay.getDate();
            isCurDay = new Date().getDay() == curDay.getDay();
            activeClass = isCurDay ? 'active' : '';
            html += '<li class="inner-col item date">' +
                         '<div class="text-c1 small-text text-center ' + activeClass + '">'+weeks[curDay.getDay()]+'</div>' +
                             '<div class="text-c3 text-center">'+ month +'/' + day + '</div>'+
                    '</li>';
          });

          $('.En-clander .clander-tab').html(html);
        }
      });
    }

  getCalendarData();

})();
