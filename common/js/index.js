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

    // synthesizing data 瓶状图----------------------------------------------------------------------------
    var billCount = ['AUD/USD','EUR/USD','GBP/USD','NZD/USD','USD/CAD','USD/CHF','USD/CNH','USD/JPY',
      'AUD/CAD','AUD/CHF','AUD/JPY','AUD/NZD','CAD/CHF','CAD/JPY','CHF/JPY','EUR/AUD','EUR/CAD','EUR/CHF',
      'EUR/GBP','EUR/JPY','EUR/NZD','GBP/AUD','GBP/CAD','GBP/CHF','GBP/JPY','GBP/NZD','NZD/JPY','XAU/USD',
      'XAG/USD','DXY','COP/PER','NG/AS','UK/OIL','US/OIL','AUS200','HKG50','HKH40','JPN225','NAS100',
      'SPX500','UK100','US30'];

    var pieChart = echarts.init(document.getElementById('ram-usage'));
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

})();
