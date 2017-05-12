(function(){

	var billCount = ['AUD/USD','EUR/USD','GBP/USD','NZD/USD','USD/CAD','USD/CHF','USD/CNH','USD/JPY',
      'AUD/CAD','AUD/CHF','AUD/JPY','AUD/NZD','CAD/CHF','CAD/JPY','CHF/JPY','EUR/AUD','EUR/CAD','EUR/CHF',
      'EUR/GBP','EUR/JPY','EUR/NZD','GBP/AUD','GBP/CAD','GBP/CHF','GBP/JPY','GBP/NZD','NZD/JPY','GOLD',
      'AUG','DXY','COPPER','NGAS','UKOIL','USOIL','AUS200','HKG50','HKH40','JPN225','NAS100',
      'SPX500','UK100','US30'];

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
                    left: '2%',
                    right: '5%',
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

	// 柱状图 交易买卖手数
	$.alpha.request_Url('post','Trading_Analysis/numberOfTransations',{},function(data){
		if(data.archive.status == 0){
			var data=data.data.numbers_ratio;
			console.log(data);
			var key = [];
			 for(var i in data){
			 	key.push(i.substring(5,10));
			 }

			var barChart = echarts.init(document.getElementById('barChart'),'purple-passion');
			var option = {
			    tooltip : {
			        trigger: 'axis',
			        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
			            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
			        }
			    },
			    legend: {},
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
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
			            name:'联盟广告',
			            type:'bar',
			            stack: '广告',
			            data:[220, 182, 191, 234, 290, 330, 310]
			        },
			        {
			            name:'邮件营销',
			            type:'bar',
			            stack: '广告',
			            data:[120, 132, 101, 134, 90, 230, 210]
			        },
			        
			    ]
			};
			barChart.setOption(option);
		}
	});

})();