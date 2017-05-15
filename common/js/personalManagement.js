(function(){

	function getStage(stage) {
	    var ctx = c1.getContext('2d');
	    ctx.lineWidth = 10;
	    ctx.font = '60px SimHei';
	    ctx.textBaseline = 'top';

	    var percent=stage;
	    // var deg=0;
	    var timer = setInterval(function(){
	      	//清除所有内容
	      	ctx.clearRect(0,0, 270, 300);

	      	//绘制外层灰色框
	      	ctx.beginPath();
	      	ctx.arc(135,150, 80, 0, 2*Math.PI);
	      	ctx.strokeStyle = 'rgba(225,225,225,.2)';
	      	ctx.stroke();

	      	//绘制圆拱形进度条
	      	ctx.beginPath();
	      	var progress=2 * Math.PI / 15 * percent;
	      	ctx.arc(135, 150, 80, 0-Math.PI/2, progress-Math.PI/2);
	      	ctx.strokeStyle = '#fff';
	      	ctx.stroke();

	      	//绘制进度提示文字
	      	var txt = percent;
	      	var w = ctx.measureText(txt).width;
	      	ctx.fillText(txt, 135-w/2, 150-30);
	      	ctx.fillStyle='#fff';
	    },50);
	}

	$.alpha.request_Url('post','Classes/current_stage',{},function(data){
		// 阶段
		var stage=data.data.current_stage;
		getStage(stage);
		// 完成情况
		var complete=data.data.complete;
		$('.description span').html(complete);
		$('.progress').html('<div class="progress-bar progress-bar-success animate-progress-bar" data-percentage="'+ complete +'%" style="width:'+ complete +'%"></div>');

	});

	
})();