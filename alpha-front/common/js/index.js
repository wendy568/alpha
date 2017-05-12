(function () {
    // description 首页正文卡片数据栏--------------------------------------------------------
    $.alpha.request_Url('post','dashboard/previews_since_today',{},function (data) {
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
    });


    // synthesizing data 综合数据接口----------------------------------------------------------------------------
    $.alpha.request_Url('post','dashboard/trading_evaluating',{},function(data){
       $('.chart .label-important').eq(0).html(data.data.risk_management_level);
       $('.chart .label-important').eq(1).html(data.data.operating_frequecy);
       $('.chart .label-info').eq(0).html(data.data.operating_accuracy);
       $('.chart .label-info').eq(1).html(data.data.trading_ability);
    });

})();