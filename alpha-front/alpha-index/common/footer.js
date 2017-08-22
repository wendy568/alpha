

var foot =`<div>
			<!-- alpha-infor -->
			<div class="alpha-infor bg2">
				<div class="container revealOnScroll" data-animation="fadeIn">
					<div class="foot-left">
						<!-- server -->
						<div class="foot-server">
							<div class="font16 m-b-50">SERVICES</div >
							<div class="flex-box">
								<a href="" target="_blank">ALPHA TRADER</a >
								<a href="" target="_blank">TRADING FLOOR</a >
								<a href="" target="_blank">TALENT PROGRAM</a >
							</div>
						</div>
						<!-- contact -->
						<div class="foot-contact relative">
							<div class="font16 m-b-50">
								CONTACT
								<div class="popover popover-default has-footer in right right-bottom" style="display: block;margin-left: 95px;z-index:800;">
									<div class="arrow"></div>
									<div class="popover-content">
										<a href="javascript:;" class="font14 text-c2 leaveMsg" target="_blank">
											Leave a message
										</a>
									</div>
								</div>
							</div>
							
							<div class="flex-box" style="width: 244px;">
								<span class="block">ADDRESS</span>
								<p>3A,1Portland Street, Manchester,M13BE,the UK</p>
								<span class="block">PHONE</span>
								<p>+44 203 637 3999</p>
								<span class="block">EMAIL</span>
								<p>info@alphatrader.co.uk</p>
							</div>
						</div>
					</div>

					<div class="foot-right">
						<div class="map m-r-40">
							
							<div id="allmap"></div>
						</div> 
						<div class="code">
							<img src="assets/img/qrcode.png" alt="" >
							<p class="text-c4">Follow Us Scan QR Code</p>
						</div>
					</div>
					
					<div class="help">
						<a href="Index.html" class="fl foot-logo" target="_blank"></a>
						<ul class="foot-navbar">
							<li class="fl">
								<a href="javascript:;" target="_blank">About Alpha</a>
							</li>
							<li class="fl">
								<a href="javascript:;" target="_blank">Join Us</a>
							</li>
							<li class="fl">
								<a href="javascript:;" target="_blank">Business Coopearation</a>
							</li>
							<li class="fl">
								<a href="javascript:;" target="_blank">FAQ</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<!-- copyright -->
			<div class="bg2 copyright text-c2">
				&copy 2017 Alpha &nbsp;京ICP备14023790号-2 京公网安备1101802017116号 &nbsp;&nbsp;&nbsp;&nbsp;Report call:028-888-88888
			</div>
		</div>`;

// <img src="assets/img/demo_map.png" alt="" />

$('.footer').html(foot);
$('.leaveMsg').on('click',function(){
	window.location.href = 'AboutUs.html?msg=5';
});
$('.foot-navbar li').on('click',function(){
	var index = ($(this).index())+1;
	window.location.href = 'AboutUs.html?msg=' + index;
})
$('#allmap').on('load',function(){
	$('.map img').addClass('hide');
})

// 百度地图API功能
var map = new BMap.Map("allmap");
map.centerAndZoom(new BMap.Point(-2.2345,53.48045),22);
map.enableScrollWheelZoom(true);
var new_point = new BMap.Point(-2.2345,53.48045);
var marker = new BMap.Marker(new_point);  // 创建标注
map.addOverlay(marker);              // 将标注添加到地图中
map.panTo(new_point);      	

