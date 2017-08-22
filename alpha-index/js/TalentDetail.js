(function(){
    // 行程安排
	$('.outside-circle img').click(function(){
        var imgIndex = $(this).index();
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $('.inside-circle').eq(imgIndex).removeClass('hide').siblings().addClass('hide');
    }).hover(function(){
        $(this).toggleClass('animated pulse');
    });

    // 往期学员
    $('.plan-time-list').click(function(){
    	var dayIndex = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('.plan-day').eq(dayIndex - 1).removeClass('hide').siblings().addClass("hide");
    });

    

    // Modal-Table

    // choose date
    new YMDselect('year1','month1','day1');

    $('.unity .order-btn').click(function(){
        $('.custom').eq(0).addClass('active').siblings().removeClass('active');
        $('.order-list').eq(0).removeClass('hide').siblings('.order-list').addClass('hide');
        var modalTitleName = $(this).parent().parent().find('.plan-name').text();
        $('.title-name').text(modalTitleName);
    });

    $('.org .order-btn').click(function(){
        $('.custom').eq(1).addClass('active').siblings().removeClass('active');
        $('.order-list').eq(1).removeClass('hide').siblings('.order-list').addClass('hide');
        var modalTitleName = $(this).parent().parent().find('.plan-name').text();
        $('.title-name').text(modalTitleName);
    });

    $('.custom').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
        var index = $(this).index();
        $('.order-list').eq(index - 1).removeClass('hide').siblings('.order-list').addClass('hide');
        
    });

    $('.camp').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });

    // default total
    $('.total').html( "€ 99.00 * 1 = € 99.00");

    

    // addPeople
    $('#individual').find('.add-btn').on('click',function(){
        addPeople('#individual');
    })
    $('#enterprise').find('.add-btn').on('click',function(){
        addPeople('#enterprise');
    })
    // deletePeople
    deletePeople('#individual');
    deletePeople('#enterprise');
})();