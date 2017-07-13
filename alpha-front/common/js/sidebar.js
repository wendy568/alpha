var user_info_userName = '';
var user_info_face = '';

(function(){
	window.onload = function(){
		if (!sessionStorage.getItem('alpha_user_info_userName')) {
			$.alpha.getUserInfo(function(data){
				var first_name = data.first_name || ' ';
	            var last_name = data.last_name || ' ';
	            var face = '';
	            sessionStorage.setItem('alpha_user_info_userName', first_name + last_name);
	            $('.username').text(first_name + last_name);
	            if(data.face){
	                $('.profile-wrapper').html('<img src=\''+ alpha_host + 'upload/'+ data.face[0] + 'm_' + data.face[1] +'\' alt=\'\'  width=\'69\' height=\'69\' />');
	                face = alpha_host + 'upload/'+ data.face[0] + 'm_' + data.face[1];
	            }else{
	                $('.profile-wrapper').html('<img src=\'assets/img/photo.png\' alt=\'\'  width=\'69\' height=\'69\' />');
	                face = 'assets/img/photo.png';
	            }
	            sessionStorage.setItem('alpha_user_info_face', face);
			});
		}else{
			user_info_userName = sessionStorage.getItem('alpha_user_info_userName') || 'User Name';
			user_info_face = sessionStorage.getItem('alpha_user_info_face') || 'assets/img/photo.png';
			$('.username').text(user_info_userName);
			$('.profile-wrapper').html('<img src=\''+ user_info_face +'\' alt=\'\'  width=\'69\' height=\'69\' />');
		}
	};
})();

document.writeln("<!-- sidebar left-->");
document.writeln("            <div class=\'page-sidebar \' id=\'main-menu\'>");
document.writeln("                <div class=\'page-sidebar-wrapper scroller scrollbar-dynamic\' id=\'main-menu-wrapper\'>");
document.writeln("                    <!-- 用户头像信息 -->");
document.writeln("                    <div class=\'user-info-wrapper sm\'>");
document.writeln("                        <!-- 头像 -->");
document.writeln("                        <a href=\'Profile.html\' class=\'profile-wrapper sm\'>");
document.writeln("                            <img src=\'"+user_info_face+"\' alt=\'\'  width=\'69\' height=\'69\' />");
document.writeln("                        </a>");
document.writeln("                        <!-- 姓名、登录状态 -->");
document.writeln("                        <div class=\'user-info sm\'>");
document.writeln("                            <div class=\'font18 semi-bold\'>Welcome</div>");
document.writeln("                            <div class=\'username\'>"+user_info_userName+"</div>");
document.writeln("                        </div>");
document.writeln("                    </div>");
document.writeln("                    <!-- 链接列表 -->");
document.writeln("                    <ul>    ");
document.writeln("                        <!-- index -->");
document.writeln("                        <li class=\'start \'> ");
document.writeln("                            <a href=\'index.html\'>");
document.writeln("                                <i class=\'fa fa-home\'></i> ");
document.writeln("                                <span class=\'title\'>Home</span> ");
document.writeln("                            </a>");
document.writeln("                        </li>");
document.writeln("                        <!-- Tra Management -->");
document.writeln("                        <li>");
document.writeln("                            <a href=\'TradingStatistic.html\'> ");
document.writeln("                                <i class=\'fa fa-bar-chart\'></i>");
document.writeln("                                <span class=\'title\'> Data Management</span> ");
document.writeln("                                <span class=\' fa fa-angle-left pull-right m-t-5\'></span> ");
document.writeln("                            </a>");
document.writeln("                            <ul class=\'sub-menu\'>");
document.writeln("                                <li> ");
document.writeln("                                    <a href=\'TradingStatistic.html\'><i class=\'fa fa-bar-chart\'></i> Trading Statistics </a> ");
document.writeln("                                </li>");
document.writeln("                                <li> ");
document.writeln("                                    <a href=\'Tools.html\'><i class=\'fa fa-suitcase\'></i> Tools</a> ");
document.writeln("                                </li>");
document.writeln("                                <li> ");
document.writeln("                                    <a href=\'Trading_History.html\'><i class=\'fa fa-history\'></i> Trading history</a> ");
document.writeln("                                </li>");
document.writeln("                            </ul>");
document.writeln("                        </li>");
document.writeln("                        <!-- Progress -->");
document.writeln("                        <li>");
document.writeln("                            <a href=\'Personal_management.html\'> ");
document.writeln("                                <i class=\'fa fa-mortar-board\'></i> ");
document.writeln("                                <span class=\'title\'> Academy </span> ");
document.writeln("                            </span>");
document.writeln("                            </a>");
document.writeln("                        </li>");
document.writeln("                        <!-- tv -->");
document.writeln("                        <li>");
document.writeln("                            <a href=\'Tv.html\'> ");
document.writeln("                                <i class=\'fa fa-tv\'></i> ");
document.writeln("                                <span class=\'title\'>TV</span> ");
document.writeln("                            </span>");
document.writeln("                            </a>");
document.writeln("                        </li>");
document.writeln("                        <!-- help -->");
document.writeln("                        <li>");
document.writeln("                            <a href=\'FAQ.html\'> ");
document.writeln("                                <i class=\'fa fa-question-circle\'></i> ");
document.writeln("                                <span class=\'title\'>FAQ</span> ");
document.writeln("                            </a>");
document.writeln("                        </li>");
document.writeln("                    </ul>");
document.writeln("                </div>");
document.writeln("            </div>");
document.writeln("            <a href=\'#\' class=\'scrollup\'>Scroll</a>");
