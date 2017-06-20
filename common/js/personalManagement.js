(function(){
  // 环形进度条JS
  function getStage(stage) {
    var c1 = document.getElementById('c1');
    var ctx = c1.getContext('2d');
    ctx.lineWidth = 10;
    ctx.font = '60px SimHei';
    ctx.textBaseline = 'top';

    var percent=stage;
    // var deg=0;
    var timer = setInterval(function(){
        //清除所有内容
        ctx.clearRect(0,0, 260, 260);

        //绘制外层灰色框
        ctx.beginPath();
        ctx.arc(130,130, 80, 0, 2*Math.PI);
        ctx.strokeStyle = 'rgba(225,225,225,.2)';
        ctx.stroke();

        //绘制圆拱形进度条
        ctx.beginPath();
        var progress=2 * Math.PI / 15 * percent;
        ctx.arc(130, 130, 80, 0-Math.PI/2, progress-Math.PI/2);
        ctx.strokeStyle = '#fff';
        ctx.stroke();

        //绘制进度提示文字
        var txt = percent;
        var w = ctx.measureText(txt).width;
        ctx.fillText(txt, 130-w/2, 130-30);
        ctx.fillStyle='#fff';
    },50);
}

  // 横向滚动
  var wheel = (window.onwheel !== undefined) ? 'wheel' :
    (window.onmousewheel !== undefined) ? 'mousewheel' :
      (window.attachEvent) ? 'onmousewheel' : 'DOMMouseScroll';
  $('#levelList').next('.scroll-y').remove();
  $('#levelList').on(wheel,function (e) {
      var event = e || window.event;
      var delta = event.originalEvent.wheelDelta;
      var left = $(this).scrollLeft();
      var x = 1;
      event.stopPropagation();
      if (event.preventDefault) {
        event.preventDefault();
      }
      left = delta < 0 ? (left + x*60) : (left + (-x)*60);
      $(this).scrollLeft(left);
  });

  // 关闭tvModal
  $('#tvModal').on('hide.bs.modal', function () {
      $('#tvModal .tv-detail-header').empty();
  });
   // 关闭articModal
  $('#articleModal').on('hide.bs.modal', function () {
      $('#articleModal .tv-detail-body').empty();
  });

  // 获取videolist
  function getVideoList(videoList) {
      var tvList = "";
      $('.tv-list').empty();
      $.each(videoList,function(i,data){
          tvList = $('<li id="'+ data.id +'" class="tv-small col-lg-3 col-md-4 col-sm-6 col-xs-12 no-margin m-b-30" data-toggle="modal" data-target="#tvModal">'+
                          '<div class="bk-img">'+
                              '<img src="'+alpha_host+'upload/'+ data.image[0] +'m_'+ data.image[1] +'" alt="" >'+
                          '</div>'+
                          '<img class="tv-btn img-responsive" src="./assets/img/dashboard_tv_play.png" alt="">'+
                          '<div class="tv-des">'+
                              '<h5 class="text-c2">'+ data.name +'</h5>'+
                          '</div>'+
                      '</li>');
          $('.tv-list').append(tvList);
      });
      $('.tv-list').on('click','.tv-small',function(){
          var vmid=$(this).attr('id');
          $.alpha.request_Url('post','Classes/record_process',{article_classes_id:vmid,look_up:'video'},function(data){});
          $.alpha.request_Url('post','video/videos_detail',{class_id:vmid},function(data){
              var tvStudy="";
              tvStudy +='<iframe id="tv" src="http://content.jwplatform.com/players/'+data.data.source+'-T351KaXB.html" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>';
              $('#tvModal .tv-detail-header').html(tvStudy);
              var tvdesc="";
              tvdesc +='<h3 class="text-c1 no-margin p-b-10">'+data.data.name+'</h3><P class="text-c3 no-padding">'+data.data.describe+'</P>';
              $('#tvModal .tv-detail-body').html(tvdesc);
          });
      });
  }
  // 获取articlelist
  function getArticleList(articleList) {
      var articList = "";
      $('.artic-list').empty();
      $.each(articleList,function(i,data){
          articList = $('<li id="'+ data.id+'" class="tv-small col-lg-3 col-md-4 col-sm-6 col-xs-12 no-margin m-b-30" data-toggle="modal" data-target="#articleModal">'+
                          '<div class="bk-img">'+
                              '<img src="'+alpha_host+'upload/'+ data.image[0] +'m_'+ data.image[1] +'" alt="" >'+
                          '</div>'+
                          '<div class="tv-des">'+
                              '<h5 class="text-c2">'+data.title+'</h5>'+
                          '</div>'+
                      '</li>');
          $('.artic-list').append(articList);
      });
      $('.artic-list').on('click','.tv-small',function(){
          var aid=$(this).attr('id');
          $.alpha.request_Url('post','Classes/article_detail',{article_id:aid},function(data){
              var artdesc="";
              artdesc +=['<div class="text-c1 tv-close close" data-dismiss="modal" style="top:0;opacity: 1;">X</div>',
                              '<h3 class="text-c1 no-margin p-b-10">',
                                  '<i class="status-icon yellow m-r-10 m-b-5"></i>',
                                  data.data.title+'</h3>',
                              '<p>'+data.data.update_time+'</p>',
                              '<P class="text-c3 no-padding">'+data.data.content+'</P>'].join('');
              $('#articleModal .tv-detail-body').html(artdesc);
          });
      });
  }
  //  获取其他课程内容
  function getStudyList(stage,stageDtail){
        var content = '';
        for(var i in stageDtail){
            if(typeof(stageDtail[i]) == 'string' || typeof(stageDtail[i]) == 'number'){
              stageDtail[i] = stageDtail[i] + '';
              content = stageDtail[i].indexOf('/') > -1 ? stageDtail[i].split('/')[0] : stageDtail[i];
            }
            var index = i;
            switch (i.toLocaleLowerCase()){
                case 'video learning':getVideoList(stageDtail[index])
                    break;
                case 'article learning':getArticleList(stageDtail[index])
                    break;
                case 'place your order':$('#stage'+ stage + ' .placeYourOrder').html(content)
                    break;
                case '4 style trade':$('#stage'+ stage + ' .4StyleTrade').html(content)
                    break;
                case 'take profits/stop loss':$('#stage'+ stage + ' .stopLoss').html(content)
                   break;
                case 'make transactions':$('#stage'+ stage + ' .makeTransactions').html(content)
                    break;
                case 'trade all kinds products':$('#stage'+ stage + ' .tradeAllKindsProducts').html(content)
                    break;
                case 'trading record':$('#stage'+ stage + ' .tradingRecord').html(content)
                    break;
                case 'learning report':$('#stage'+ stage + ' .learningReport').html(content)
                    break;
                case 'make transaction 1':$('#stage'+ stage + ' .makeTransactionOn').html(content)
                    break;
                case 'make transaction 2':$('#stage'+ stage + ' .makeTransactionTwo').html(content)
                    break;
                case 'task 1 - 2 different markets':$('#stage'+ stage + ' .2DifferentMarkets').html(content)
                    break;
                case 'task 2 - 10 different products':$('#stage'+ stage + ' .10DifferentProducts').html(content)
                    break;
                case '5 tradable products':$('#stage'+ stage + ' .5TradableProducts').html(content)
                    break;
                case 'produce a module':$('#stage'+ stage + ' .produceAModule').html(content)
                    break;
                case 'risk management level':$('#stage'+ stage + ' .riskManagementLevel').html(content)
                    break;
                case 'trading score':$('#stage'+ stage + ' .tradingScore').html(content)
                    break;
                case 'profitable period':$('#stage'+ stage + ' .profitablePeriod').html(content)
                    break;
            }
        }
    }

	$.alpha.request_Url('post','Classes/current_stage',{},function(data){
		// 阶段展示
		var stage=data.data.current_stage;
		getStage(stage);
		if(stage > 8){
      $('#levelList').scrollLeft(stage*147);
    }
		// 完成情况
		var complete=data.data.complete;
		$('.description span').html(complete*100 + '%');
		$('.stage-left .progress').html('<div class="progress-bar progress-bar-success animate-progress-bar" data-percentage="'+ complete*100 +'%" style="width:'+ complete*100 +'%"></div>');

		// title
		$('.pro-intr h4').html(data.data.title);

        // 阶段描述点击获取全文
        var desc=data.data.describe.substr(0,80);
        var i=0;
        $('.more').html('Continue Reading...');
        $('.more').click(function(){
            if(i == 0){
                desc=data.data.describe;
                $(this).html('Pack Up The Full...');
                i = i +1;
            }else{
                desc=data.data.describe.substr(0,80);
                $(this).html('Continue Reading...');
                i = 0;
            }
            $('.pro-intr p').html(desc);
        });
        $('.pro-intr p').html(desc);

		// 定位 stage learning
		$('.roll-list li').removeClass('active');
		$('.tab-pane').removeClass('active');
		$('.roll-list li').eq(stage-1).addClass('active');
		$('.tab-pane').eq(stage-1).addClass('active');

		// 获取课程内容
		var stageDtail=data.data.detail;
        getStudyList(stage,stageDtail);
	});

    $('.module').click(function(){
        var stage_id = parseInt($(this).index()) + 1;
        $.alpha.request_Url('post','Classes/showStageDetail',{stage_id:stage_id},function(data){
            // title
            $('.pro-intr h4').html(data.data.title);
             // 阶段描述点击获取全文
            var desc=data.data.describe.substr(0,80);
            var i=0;
            $('.more').html('Continue Reading...');
            $('.more').click(function(){
                if(i == 0){
                    desc=data.data.describe;
                    $(this).html('Pack Up The Full...');
                    i = i +1;
                }else{
                    desc=data.data.describe.substr(0,80);
                    $(this).html('Continue Reading...');
                    i = 0;
                }
                $('.pro-intr p').html(desc);
            });
            $('.pro-intr p').html(desc);

            var stageDtail=data.data.detail;
            getStudyList(stage_id,stageDtail);
        });
    });
   
})();
