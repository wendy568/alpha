(function(){
	var userName = "";
	var login = '<div class="container">'+
		            '<a href="../login/Login.html" class="fr font14" style="color: #fff" target="_blank">'+
						'<img  src="assets/img/photo.png"  alt="" class="userFace m-r-5"/>'+
		                '<span>Login/Register</span>'+
		            '</a>'+
				'</div>';
	$('.head').html(login);

	if(sessionStorage.getItem('alpha_token')){
		if (!sessionStorage.getItem('alpha_user_info_userName')) {
			getUserInfo(function(data){
				userName = data.first_name + ' ' + data.last_name;
				userFace = data.face ? alpha_host + 'upload/'+ data.face[0] + 'm_' + data.face[1] : ' assets/img/photo.png ';
				sessionStorage.setItem('alpha_user_info_userName', userName);
				sessionStorage.setItem('alpha_user_info_face', userFace);
				var user =	'<div class="container">'+
					            '<a href="../user-center/index.html" class="fr font14 clearfix" style="color: #fff" target="_blank">'+
									'<img  src="'+ userFace +'"  alt="" class="userFace m-r-5"/>'+
					                '<span class="m-r-5">'+ userName +'</span>'+
					                '<i  class="icon-vip2"></i>'+
					            '</a>'+
							'</div>';
				$('.head').html(user);
				
			});
		}else{
			userName = sessionStorage.getItem('alpha_user_info_userName');
			userFace = sessionStorage.getItem('alpha_user_info_face');
			var user =	'<div class="container">'+
			            '<a href="../user-center/index.html" class="fr font14 clearfix" style="color: #fff" target="_blank">'+
			                '<img src="'+ userFace +'" alt="" class="userFace m-r-5"/>'+
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

