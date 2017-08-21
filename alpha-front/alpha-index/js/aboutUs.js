/**
 * Created by alpharghrtbrtgt on 2017/8/3.
 */

(function () {
    $('.about .tab li').click(function (e) {
        var index = $(this).index();
        var value = $(this).text();
        $(this).addClass('active').siblings().removeClass('active');
        $('.tab-content').eq(index).addClass('show').siblings('.tab-content').removeClass('show');
        $('.row-1 td').eq(1).text(value);
    });
    
    
    
    var type='replay1';
   $('.replay').click(function (e) {
       var index = parseInt($(this).index());
       $(this).addClass('checked').siblings().removeClass('checked');
       type = 'replay' + parseInt(index + 1);
       
   });
    
    $('.anw').on('show.bs.collapse', function () {
        var target = $(this).siblings().find('span.fr');
        target.addClass('icon-faq_minus').removeClass('icon-faq_plus');
    }).on('hide.bs.collapse', function () {
        var target = $(this).siblings().find('span.fr');
        target.addClass('icon-faq_plus').removeClass('icon-faq_minus');
    });
    
    $('.faq-title a').click(function () {
        $(this).addClass('active').parent().parent().siblings().find('.faq-title a').removeClass('active');
    });


    var target = window.location.href.split('=')[1];
    if(target){
        $('.tab li').eq(target-1).addClass('active').siblings().removeClass('active');
        $('.tab-content').eq(target-1).addClass('show').siblings('.tab-content').removeClass('show');
        $('.row-1 td').eq(1).text($('.tab li').eq(target-1).text());
    }
})();