

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
							<img src="assets/img/demo_map.png" alt="" />
							<iframe src="http://www.google.cn/maps/embed?pb=!1m18!1m12!1m3!1d3436.06250738001!2d104.06118331559031!3d30.54753798170206!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x36efc651ba745623%3A0xb59890c140b6d5e3!2z6IW-6K6v5oiQ6YO95aSn5Y6mQealvA!5e0!3m2!1szh-CN!2scn!4v1500977506155" width="436" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
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
$('.map iframe').on('load',function(){
	$('.map img').addClass('hide');
})



