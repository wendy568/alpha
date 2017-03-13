<!--[if lt IE 8]>
	<script>
		$(function() {
			$(".filter ul li a").click(function () {
				var e = window.event || arguments[0];
				if(e.preventDefault){
					e.preventDefault();
				}else{
					e.returnValue=false;
				}
				var target = e.srcElement || e.target;
				$(target).addClass("active").parent().siblings("li").not($(target).parent()).children("a").removeClass("active");

				if ($(target).attr("data-filter") !== "*") {
					$(".class" + ($(target).attr("data-filter").substr(6, 1) - 1)).removeClass("panel-hide").siblings().not($(target)).addClass("panel-hide");
				} else {
					$(".filter-container").find("li").removeClass("panel-hide");
				}
			})
		})
	</script>
<![endif]-->
		<!-- End Header -->
		<!-- content -->
				<div id="content">
			<div class="breadcrumbs2 mb50">
				<div class="container">
					<h1>维望业务</h1>
					<div class="sitemap2">
						<a href="index.html">Home</a>  / corporate business
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<!-- end breadcrumbs -->
			<div class="portfolio1column">
				<div class="container">
					<div class="filters">
						<div class="filter clearfix">
							<ul>
								<li><a  href="javascript:void(0);" class="active" data-filter="*">查看所有业务</a></li>
                                <!-- <li><a  href="javascript:void(0);" data-filter=".class1">私募基金管理</a></li>
								<li><a  href="javascript:void(0);" data-filter=".class2">天使A轮投资</a></li>
								<li><a  href="javascript:void(0);" data-filter=".class4">海内外量化对冲套利</a></li>
								<li><a  href="javascript:void(0);" data-filter=".class3">股权投资</a></li>
								<li><a  href="javascript:void(0);" data-filter=".class5">全球各大交易市场提供交易订单</a></li> -->
							</ul>
						</div>

						<div class="clear"></div>
						<ul class="filter-container onecolumn clearfix">
							
						</ul>
					</div>
				</div>
			</div>
			<!-- End Portfolio1column -->
			<div class="love3">
			<div class="container">
				<div class="dis-table">
				<h1 class="maintitle white-color">客户利益至上 实现多赢共享</h1>
				<a href="<?=site_url(array('home','about'))?>"><i class="fa fa-arrow-circle-o-right"></i></a>
				</div>
			</div>
			</div>
			<script>	
					var datas; 
					datas = JSON.parse('<?=$datas?>');
					var inner='';
					var tab="";
					for(var i=0;i<datas.length;i++){
						tab='<li><a  href="javascript:void(0);" data-filter=".class'+(datas[i].id)+'">'+(datas[i].title)+'</a></li>'
						$(".filter>ul").append(tab);
					}
					for(var i=0;i<datas.length;i++){
						inner=
							'<li class="class'+(datas[i].id)+' mb50">'+
								'<div class="overlay2 left">'+
								    '<a href="#"><img src="<?=base_url()?>upload/m_'+datas[i].image+'" alt="" /></a>'+
								'</div>'+
								'<div class="port1-text right">'+
									'<h1>'+datas[i].title+'</h1>'+
									'<div class="leftmain-border"></div>'+
									'<p>'+datas[i].describe+'</p>'+
									'<a href="mailto:info@wecapital.com" class="button-light button-small">Contact WeWant</a>'+
								'</div>'+
								'<div class="clear"></div>'+
							'</li>';
						$(".filter-container").append(inner);
					}
					for(var i=1;i<=datas.length;i++){
						if(i%2==0){
							$(".class"+i+">.overlay2").addClass("right");
							$(".class"+i+">.port1-text").addClass("left");
						}
					}
			</script>
			<!-- End Love -->