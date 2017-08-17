(function(){
	var userName = "";
	var login = '<div class="container">'+
		            '<a href="../login/Login.html" class="fr font14" style="color: #fff" target="_blank">'+
		                '<i class="glyphicon glyphicon-user m-r-5"></i>'+
		                '<span>Login/Register</span>'+
		            '</a>'+
				'</div>';
	$('.head').html(login);

	if(sessionStorage.getItem('alpha_token')){
		if (!sessionStorage.getItem('alpha_user_info_userName')) {
			getUserInfo(function(data){
				userName = data.first_name + ' ' + data.last_name;
				var user =	'<div class="container">'+
			            '<a href="../user-center/index.html" class="fr font14 clearfix" style="color: #fff" target="_blank">'+
			                '<i class="glyphicon glyphicon-user m-r-5"></i>'+
			                '<span class="m-r-5">'+ userName +'</span>'+
			                '<i  class="icon-vip2"></i>'+
			            '</a>'+
					'</div>';
				$('.head').html(user);
			});
		}else{
			userName = sessionStorage.getItem('alpha_user_info_userName');
			var user =	'<div class="container">'+
			            '<a href="../user-center/index.html" class="fr font14 clearfix" style="color: #fff" target="_blank">'+
			                '<i class="glyphicon glyphicon-user m-r-5"></i>'+
			                '<span class="m-r-5">'+ userName +'</span>'+
			                '<i  class="icon-vip2"></i>'+
			            '</a>'+
					'</div>';
			$('.head').html(user);
		}
	}else{
		console.log('no token');
	}
})();

