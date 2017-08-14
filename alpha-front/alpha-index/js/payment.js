/**
 * Created by alpharghrtbrtgt on 2017/8/7.
 */
(function () {
    var payBill = 0;
    $('.product .thead input').change(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        var value = $(this).prop('checked');
        $('.product .tbody input').prop('checked',value);
        getTotal();
    })
    
    $('.product .tbody input').change(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        getTotal();
    })
    
    $('.product .tbody .remove span').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        var $ctr = $(this).parents('tr');
        $ctr.remove();
        getTotal();
    })
    
    // 下一步
    $('.step1 .r').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        var total = parseInt($('.total .fl .text-c1').text().substring(1)) + parseInt($('.total .fl .text-c4').text()) * 0.01;
        $('.step-box>div').eq(1).addClass('actived');
        $('.step2').addClass('show').siblings().removeClass('show');
        payBill = total;
        $('.step2 .payCount').text('$' + payBill);
    });
    
    $('.step2 .type-select').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        var src = $(this).find('img').attr('src');
        var newSrc = src.indexOf('_s.svg') > -1 ? src : src.split('.svg')[0] + '_s.svg';
        var otherSrc = $(this).parent().siblings().find('.type-select img').attr('src');
        otherSrc = otherSrc.indexOf('_s.svg') > -1 ? otherSrc.split('_s.svg')[0] + '.svg' : otherSrc;
        $('.step2 .type-select').removeClass('selected');
        $(this).addClass('selected').find('img').attr('src',newSrc);
        $(this).parent().siblings().find('.type-select img').attr('src',otherSrc);
    })
    
    getAll();
    getTotal();
    
    // 计算总价
    function getTotal () {
        var trs = $('.product tbody tr');
        var total = 0;
        $.each(trs,function (index, item) {
            var price = Number($(item).find('td').eq(4).find('div').text());
            var quantity = Number($(item).find('td').eq(5).find('div').text());
            var isCount = $(item).find('td').eq(0).find('input').prop('checked');
            if (isCount){
                total += price * quantity;
            }
        })
        total = total.toFixed(2);
        
        $('.total .fl .text-c1').text('$' + total.split('.')[0]);
        $('.total .fl .text-c4').text(total.split('.')[1]);
        
        if(total > 0){
            $('.step1 .r').show();
        }else{
            $('.step1 .r').hide();
        }
    }
    
    // 全选
    function getAll () {
        $('.product .tbody input').prop('checked',true);
        $('.product .thead input').prop('checked',true);
    }
})()