(function(){

	var billCount = ['AUD/USD','EUR/USD','GBP/USD','NZD/USD','USD/CAD','USD/CHF','USD/CNH','USD/JPY',
      'AUD/CAD','AUD/CHF','AUD/JPY','AUD/NZD','CAD/CHF','CAD/JPY','CHF/JPY','EUR/AUD','EUR/CAD','EUR/CHF',
      'EUR/GBP','EUR/JPY','EUR/NZD','GBP/AUD','GBP/CAD','GBP/CHF','GBP/JPY','GBP/NZD','NZD/JPY','GOLD',
      'AUG','DXY','COPPER','NGAS','UKOIL','USOIL','AUS200','HKG50','HKH40','JPN225','NAS100',
      'SPX500','UK100','US30'];
	
	// 监听货币选项卡加载数据
	$('.page-content .tabs li.tab').on('click',function (e) {
      e.stopPropagation();
      $(this).siblings('li.tab').removeClass('active').addClass('active');
      var curBill = $(this).find('.currency').text();
  });

	// 交易数据计算
	function getTraData(bill){
		$.alpha.request_Url('post','Trading_Analysis/calculator_anytime',{},function(data){
			if(data.archive.status == 0){
				$('.risk .label').eq(0).html(data.data.operating_accuracy);
				$('.risk .label').eq(1).html(data.data.operating_frequecy);
				$('.risk .label').eq(2).html(data.data.risk_management_level);
				$('.risk .label').eq(3).html(data.data.trading_ability);
			}
		});
	};
	getTraData($('.tab span').text());


	// 收益净值
	$.alpha.request_Url('post','Trading_Analysis/profit_loss',{},function(data){
		if(data.archive.status == 0){
			var total_html="";
			total_html +=
			`<h4 class="item-count animate-number semi-bold bg-purple">$${data.data.profit_total}</h4>`;
			$('.wrapper').html(total_html);
		}
	});
	

	// 折线图
	$.alpha.request_Url('post','Trading_Analysis/profit_curve',{},function(data){
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
  
  // synthesizing data 环形图----------------------------------------------------------------------------
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
  

	// 柱状图 交易买卖手数
	$.alpha.request_Url('post','Trading_Analysis/numberOfTransations',{},function(data){
		if(data.archive.status == 0){
			var data=data.data.numbers_ratio;
		
			var key = [];
		
			var buy=[];
			var sell=[];

			for(var i in data){
			 	key.push(i.substring(5,10));

			 	var x = data[i];
			 	console.log(x);
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
			            barWidth:8,
			        },
			        {
			         
			            name:'卖',
			            type:'bar',
			       
			            stack: 1,
			            data:sell,
			            barWidth:8,
			        },
			        
			    ]
			};
			barChart.setOption(option);
		}
	});

})();

