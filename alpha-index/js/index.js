(function(){
   
    // learning  tabs
    $('.list-bottom li').hover(function(){
    	var liIndex = $(this).index();
    	$(this).addClass('active');
    	$(this).siblings().removeClass('active');
    	$('.learn-list').eq(liIndex).removeClass('hide');
    	$('.learn-list').eq(liIndex).siblings().addClass('hide');
    });

})();	