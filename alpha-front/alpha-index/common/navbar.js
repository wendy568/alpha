(function(){
	var html = `<div class="container navbar no-border block-navbar" style="height: 50px;overflow: visible;">
					<a href="index.html" class="alpha-logo"></a>
					<ul class="nav nav-tabs no-border m-t-10 fr">
						<li>
							<a href="Trader.html" target="_blank">
						  		ALPHA TRADER&nbsp;&nbsp;/
						  		<div class="bottom-line"></div>
						  	</a>
						</li>
						<li>
							<a href="TradingFloor.html" target="_blank">
								TRADING FLOOR&nbsp;&nbsp;/
								<div class="bottom-line"></div>
							</a>
						</li>
						<li>
							<a href="Talent.html" target="_blank">
								TALENT PROGRAM&nbsp;&nbsp;/
								<div class="bottom-line"></div>
							</a>
						</li>
						<li class="aboutUs">
							<a href="AboutUs.html"  target="_blank" class="relative">
								ABOUT US
								<div class="bottom-line"></div>
							</a>
							<ul class="about">
								<li class="m-b-20">
									<a href="AboutUs.html" target="_blank">ABOUT ALPHA</a>
								</li>
								<li class="m-b-20">
									<a href="AboutUs.html" target="_blank">JOIN US</a>
								</li>
								<li class="m-b-20">
									<a href="AboutUs.html" target="_blank">COOPERATION</a>
								</li>
								<li class="m-b-20">
									<a href="AboutUs.html" target="_blank">FAQ</a>
								</li>
								<li>
									<a href="AboutUs.html" target="_blank">CONTACT</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="white-navbar animated fadeInDown">
					<div class="container navbar no-border " style="height: 50px;overflow: visible;">
						<a href="index.html" class="alpha-logo-block"></a>
						<ul class="nav nav-tabs no-border m-t-10 fr">
							<li>
								<a href="Trader.html" target="_blank">
							  		ALPHA TRADER&nbsp;&nbsp;/
							  		<div class="bottom-line"></div>
							  	</a>
							</li>
							<li>
								<a href="TradingFloor.html" target="_blank">
									TRADING FLOOR&nbsp;&nbsp;/
									<div class="bottom-line"></div>
								</a>
							</li>
							<li>
								<a href="Talent.html" target="_blank">
									TALENT PROGRAM&nbsp;&nbsp;/
									<div class="bottom-line"></div>
								</a>
							</li>
							<li class="aboutUs">
								<a href="AboutUs.html"  target="_blank" class="relative">
									ABOUT US
									<div class="bottom-line"></div>
								</a>
								<ul class="about">
									<li class="m-b-20">
										<a href="AboutUs.html" target="_blank">ABOUT ALPHA</a>
									</li>
									<li class="m-b-20">
										<a href="AboutUs.html" target="_blank">JOIN US</a>
									</li>
									<li class="m-b-20">
										<a href="AboutUs.html" target="_blank">COOPERATION</a>
									</li>
									<li class="m-b-20">
										<a href="AboutUs.html" target="_blank">FAQ</a>
									</li>
									<li>
										<a href="AboutUs.html" target="_blank">CONTACT</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>`;
	$('.navbar').html(html);
	
	$(window).on('scroll', function(){
        var $scrollTop = $(window).scrollTop();
        if($scrollTop >90){
            $('.white-navbar').show();
        }else{
            $('.white-navbar').hide();
        }
     });
})();