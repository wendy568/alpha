/**
 * Created by alpharghrtbrtgt on 2017/7/31.
 */

(function  () {
    // 视频播放窗口
    request_Url('post','video/videos_detail',{'class_id':9},function(data){
        // 视频播放窗口
        var html = "";
        html += '<iframe id="tv" src="http://content.jwplatform.com/players/'+data.data.source+'-T351KaXB.html" width="100%" height="100%" frameborder="0" allowfullscreen name="tv"></iframe>';
        $('.trader-video').html(html);
    });

    $('a').click(function(){
        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top
        }, 500);
        return false;
    });
    
    function init() {
        $('.stage-content').scrollLeft(250*$('.justify span.active').prevAll('span').length);
    }
    
    $('.justify span i').click(function (e) {
        var event = e || window.event;
        var index = $(this).parent().index();
        var width = $(this).parent().width();
        event.stopPropagation();
        $(this).parent().addClass('active').width(width).siblings().removeClass('active');
        $('.stage-content').stop().animate({'scrollLeft':250 * index},500);
    });
    
    $('.cart-left').click(function () {
        var index = $('.justify span.active').prevAll('span').length - 1;
        var width = $('.justify span.active').prev('span').width();
        $('.justify span.active').prev('span').addClass('active').width(width).siblings().removeClass('active');
        $('.stage-content').stop().animate({'scrollLeft':250 * index},500);
    });
    
    $('.cart-right').click(function () {
        var index = parseInt($('.justify span.active').prevAll('span').length) + 1;
        var width = $('.justify span.active').next('span').width();
        $('.justify span.active').next('span').addClass('active').width(width).siblings().removeClass('active');
        $('.stage-content').stop().animate({'scrollLeft':250 * index},500);
    });
    init();

    // Modal-Table
    $('.custom').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('.camp').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });

    $('.submit-btn').click(function(){
        buyCartAlert();
        $('#memberModal').modal('hide');
    });
})();