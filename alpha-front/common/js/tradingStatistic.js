(function(){

    // 货币种类
    var billCount = ['AUD/USD','GBP/USD','NZD/USD','USD/CAD','USD/CHF','USD/CNH','USD/JPY',
        'AUD/CAD','AUD/CHF','AUD/JPY','AUD/NZD','CAD/CHF','CAD/JPY','CHF/JPY','EUR/AUD','EUR/CAD','EUR/CHF',
        'EUR/GBP','EUR/JPY','EUR/NZD','GBP/AUD','GBP/CAD','GBP/CHF','GBP/JPY','GBP/NZD','NZD/JPY','GOLD',
        'AUG','DXY','COPPER','NGAS','UKOIL','USOIL','AUS200','HKG50','HKH40','JPN225','NAS100',
        'SPX500','UK100','US30'];
    var oFragment = document.createDocumentFragment();
    
    $.each(billCount,function (i,item) {
        var $li = $('<li><a href="#'+i+'">'+item+'</a></li>');
    
        // 选择货币
        $li.click(function(){
            var currText=$(this).children('a').text();
            var currId=$(this).children('a').attr('href');
            var $this = $(this);
            var $currLiHtml =
            $('<li class="tab"><a href="javascript:;">'+
                '<span class="currency">'+currText+'</span>'+
              '<div class="controller"><a href="javascript:;" class="remove"></a></div></a></li>');
            
            $currLiHtml.find('.controller .remove').click(function () {
              $(this).parent().parent().addClass('animated fadeOut');
              $(this).parent().parent().attr('id', 'id_remove');
              setTimeout(function () {
                $('#id_remove').remove();
              }, 200);
              $this.show();
            });
            $currLiHtml.click(function (e) {
                e.stopPropagation();
                $('.page-content .tabs>.tab').removeClass('active');
                $(this).addClass('active');
                var curBill = $(this).find('.currency').text().replace('/','');
                var startTime = $('input[name="startTime"]').val();
                var endTime = $('input[name="endTime"]').val();
                var param = {
                  finency_proc : curBill,
                  start_time : startTime ? new Daste(startTime).getTime()/1000 : null,
                  end_time : endTime ? new Date(endTime).getTime()/1000 : null
                };
  
                getAllData(param);
            });
            
            $('.last-tab').before($currLiHtml);
            $this.hide();
        });
        $(oFragment).append($li);
    });
    
    $('.dropdown-menu').append($(oFragment));
	
    // 监听货币选项卡加载数据
    $('.page-content .tabs>.tab').on('click',function (e) {
        e.stopPropagation();
        $('.page-content .tabs>.tab').removeClass('active');
        $(this).addClass('active');
        var curBill = $(this).find('.currency').text().replace('/','');
        var startTime = $('input[name="startTime"]').val();
        var endTime = $('input[name="endTime"]').val();
        var param = {
            finency_proc : curBill,
            start_time : startTime ? new Daste(startTime).getTime()/1000 : null,
            end_time : endTime ? new Date(endTime).getTime()/1000 : null
        };
        
        getAllData(param);
    });
    
    $('.today').click(function (e) {
        e.stopPropagation();
        var curBill = $('.page-content .tabs>.tab.active').find('.currency').text().replace('/','');
        var param = {
          finency_proc : curBill,
          start_time : new Date().getTime()/1000,
          end_time : new Date().getTime()/1000
        };
        getAllData(param);
    });
    
    getAllData({finency_proc:'EUR/USD'});
    
    function getAllData(param) {
        getTraData(param);
        getLossData(param);
        gatLineData(param);
        getPieData(param);
        getBarData(param);
        getAllTradingStatistics(param);
    }

    // 交易数据计算
    function getTraData(params){
      $.alpha.request_Url('post','Trading_Analysis/calculator_anytime',params,function(data){
        if(data.archive.status == 0){
          $('.risk .label').eq(0).html(data.data.operating_accuracy);
          $('.risk .label').eq(1).html(data.data.operating_frequecy);
          $('.risk .label').eq(2).html(data.data.risk_management_level);
          $('.risk .label').eq(3).html(data.data.trading_ability);
        }
      });
    }
  
    // 收益净值
    function getLossData(params){
      $.alpha.request_Url('post','Trading_Analysis/profit_loss',params,function(data){
        if(data.archive.status == 0){
          var total_html='<h4 class="item-count animate-number semi-bold bg-purple">$'+data.data.profit_total+'</h4>';
          $('.wrapper').html(total_html);
        }
      });
    }

    // 折线图
    function gatLineData(params){
      $.alpha.request_Url('post','Trading_Analysis/profit_curve',params,function(data){
        if(data.archive.status == 0){
          var date=data.data.profit_week;
                var key=[];
                var currData=[];

                for(var i in date){
                    key.push(i.substring(5,10));
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
                        left: '2%',
                        right: '5%',
                        bottom: '3%',
                    
                        containLabel: true,
                        height:250,
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
    }

  
    // synthesizing data 环形图----------------------------------------------------------------------------
    function getPieData(params) {
        $.alpha.request_Url('post','Trading_Analysis/long_short_ratio',params,function(data){
            if(data.archive.status == 0){
                var billData = [];
                billData[0] = {name:'BUY',value:data.data.percent_ratio._0 * 100};
                billData[1] = {name:'SELL',value:data.data.percent_ratio._1 * 100};
          
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
                      data:billData
                    }
                  ]
                });
            }
        });
    }
  

    // 柱状图 交易买卖手数
    function getBarData(params){
      $.alpha.request_Url('post','Trading_Analysis/numberOfTransations',params,function(data){
        if(data.archive.status == 0){
          var data=data.data.numbers_ratio;
          var key = [];
          var buy=[];
          var sell=[];

          for(var i in data){
            key.push(i.substring(5,10));
            var x = data[i];
            buy.push(x && x._0 ? x._0 : 0);
            sell.push(x && x._1 ? x._1 : 0);
          }
          
          var barChart = echarts.init(document.getElementById('barChart'),'purple-passion');
          var option = {
              tooltip : {
                  trigger: 'axis',
      
                  axisPointer : {
                      type : 'shadow'
                  }
              },
              legend: {},
              grid: {
                
                  left: '2%',
                  right: '4%',
           
                  bottom: '2%',
                  containLabel: true,
                  height: 250
              },
              xAxis : [
                  {
                      type : 'category',
                      data : key
                  }
              ],
              yAxis : [
                  {
                      type : 'value'
                  }
              ],
              series : [
                {
                      name:'买',
                      type:'bar',
                
                      stack: 1,
                      data:buy,
                      barWidth:8
                  },
                  {
                      name:'卖',
                      type:'bar',
                 
                      stack: 1,
                      data:sell,
                      barWidth:8
                  }
                  
              ]
          };
          barChart.setOption(option);
        }
      });
    }
  
    //  allTradingStatistics  交易数据----------------------------------------------------------------------------
    function getAllTradingStatistics(params) {
        var $td = $('.all-trading-statistics tbody td');
        var $NetProfit = $td.eq(0).find('span');
        var $averageProfit = $td.eq(1).find('span');
        var $averageLoss = $td.eq(2).find('span');
        var $maximunConsecutiveProfit = $td.eq(3).find('span');
        var $aveHoldingtime = $td.eq(4).find('span');
        var $riskManagementLevel = $td.eq(5).find('span').eq(0);
        var $riskManagementLevel_label = $td.eq(5).find('span').eq(1);
  
        $.alpha.request_Url('post','Trading_Analysis/allTradingStatistics',params,function(data){
          if(data.archive.status == 0){
            var time = data.data.Avg_holding_Time;
            var days = parseInt(time/3600/24);
            var hours = parseInt(time/3600) - days*24;
            var min = parseInt(time/60) - hours*60 - days*24*60;
            var sec = time - hours*60*60 - days*24*60*60 - min*60;
            
            data.data.Net_profit && $NetProfit.html(data.data.Net_profit >= 0 ? '$'+data.data.Net_profit : '-$' + Math.abs(data.data.Net_profit));
            data.data.Average_Profits && $averageProfit.html(data.data.Average_Profits >= 0 ? '$'+data.data.Average_Profits : '-$' + Math.abs(data.data.Average_Profits));
            data.data.Average_Loss && $averageLoss.html(data.data.Average_Loss >= 0 ? '$'+data.data.Average_LossAverage_Loss : '-$' + Math.abs(data.data.Average_Loss));
            data.data.Maximum_Consecutive_Profit && $maximunConsecutiveProfit.html(data.data.Maximum_Consecutive_Profit);
            time && $aveHoldingtime.html(days+'days '+hours+'h '+min+'m '+sec+'s');
            data.data.risk_management_level && $riskManagementLevel.html(data.data.risk_management_level);
          }
        });
    }
})();
