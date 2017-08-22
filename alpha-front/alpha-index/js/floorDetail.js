(function(){
	// Modal-Table
    $('.custom').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('.camp').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });

   // default total
    $('.total').html( "€ 99.00 * 1 = € 99.00");

    new YMDselect('year1','month1','day1');
    $('.last iframe').on('load',function(){
        $('.last img').addClass('hide');
    });
})();