(function(){
    // 行程安排
	$('.outside-circle img').click(function(){
        var imgIndex = $(this).index();
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $('.inside-circle').eq(imgIndex).removeClass('hide').siblings().addClass('hide');
    });

    // 往期学员
    $('.plan-time-list').click(function(){
    	var dayIndex = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('.plan-day').eq(dayIndex - 1).removeClass('hide').siblings().addClass("hide");
    });

    // Modal-Table
    $('.custom').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('.camp').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });

   // default total
    $('.total').html( "€ 99.00 * 1 = € 99.00");

    // addPeople
    $('#personalModal .add-btn').click(function(){
        addPeople('#personalModal');
    });

    $('#enterpriseModal .add-btn').click(function(){
        addPeople('#enterpriseModal');
    });
    $('.outside-circle img').hover(function(){
        $(this).toggleClass('animated pulse');
    })

    // deletePeople
    deletePeople('#personalModal');
    deletePeople('#enterpriseModal');

    new YMDselect('year1','month1','day1');
})();