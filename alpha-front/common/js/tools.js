(function(){
	$('.log').hover(function(){
        $(this).children('.log-foot').toggleClass('hide');
    });

    $('.fa-close').click(function(){
        $('#logModal').removeClass('in');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').removeClass('modal-backdrop');
    });

    // 选择添加工具
    $('.dropdown-menu>li').click(function(){
        var tool_iClass=$(this).find('i').attr('class');
        var tool_pText=$(this).children('p').text();
        function initToolHtml(){
            var tool_html='';
            
            tool_html+= `<li class="module">`;
            tool_html+=     `<a href="#`+tool_pText+`" role="tab" data-toggle="tab">`;
            tool_html+=         `<div class="module-icon">`;
            tool_html+=             `<i class="`+tool_iClass+`"></i>`;
            tool_html+=         `</div>`;
            tool_html+=         `<p class="text-center text-c4">`+tool_pText+`</p>`;
            tool_html+=     `</a>`;
            tool_html+= `</li>`;

            return tool_html;
        };
        $('.toolbar>ul>li:last').before(initToolHtml());
        $(this).remove();
    });

})();