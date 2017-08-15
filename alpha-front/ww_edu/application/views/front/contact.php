<div class="breadcrumbs2 banner6">
			<div class="container">
				<h1>联系我们</h1>
				<div class="sitemap2">
					<a href="index.html">Home </a>  /  Contact
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<!-- end breadcrumbs -->
		<!-- content 
			================================================== -->
		<div id="content">
			<div class="contact-content">
				<div class="contact">
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-lg-8 col-xs-12">
								<div id="map">
								</div>
							</div>
							<!-- end contactfort -->
							<div class="col-md-4 col-lg-4 col-xs-12 touch">
								<div class="row">
									<div class="phone-box mb30 col-xs-12 workplace">
										<h2>工作时间</h2>
										<p class="mb50">周一到周五上班时间<br/>
											9:00点至18：00点。</p>
									</div>
									<div class="phone-box mb30 col-xs-12">
										<i class="fa fa-phone"></i>
										<h2>公司电话</h2>
										<p>+86 （028）85 00 99 88</p>
									</div>

									<div class="mail-box mb30 col-xs-12">
										<i class="fa fa-envelope"></i>
										<h2>公司邮箱</h2>
										<a href="#"><p>info@wecapital.com</p></a>
									</div>

									<div class="phone-box mb30 col-xs-12">
										<i class="fa fa-map-marker"></i>
										<h2>公司地址</h2>
										<p>四川省成都市新高新区交子大道88号中航国际广场</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Map -->
			</div>
			<!-- End Contact Content -->
			<!-- End Love -->
		<!-- End content -->
		<!-- footer 
			================================================== -->
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ArOflXGo3yrbscTD4KY3iO5A"></script>
	<script>
		//创建和初始化地图函数：
		function initMap(){
			createMap();//创建地图
			setMapEvent();//设置地图事件
			addMapControl();//向地图添加控件
			addMapOverlay();//向地图添加覆盖物
		}
		function createMap(){
			map = new BMap.Map("map");
			map.centerAndZoom(new BMap.Point(104.068027,30.589737),19);
		}
		function setMapEvent(){
			map.enableScrollWheelZoom();
			map.enableKeyboard();
			map.enableDragging();
			map.enableDoubleClickZoom();
			/********跳动的图标*******/
			var point = new BMap.Point(104.068027,30.589737);
			var marker = new BMap.Marker(point);  // 创建标注
			map.addOverlay(marker);               // 将标注添加到地图中
			marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
			/*****文字标注*****/
			var label = new BMap.Label("维望资产管理有限公司",{offset:new BMap.Size(20,-10)});
			marker.setLabel(label);
		}
		function addClickHandler(target,window){
			target.addEventListener("click",function(){
				target.openInfoWindow(window);
			});
		}
		function addMapOverlay(){
		}
		//向地图添加控件
		function addMapControl(){
			var scaleControl = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
			scaleControl.setUnit(BMAP_UNIT_IMPERIAL);
			map.addControl(scaleControl);
			var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
			map.addControl(navControl);
			var overviewControl = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:true});
			map.addControl(overviewControl);
		}
		var map=document.getElementById("map");
		initMap();
	</script>