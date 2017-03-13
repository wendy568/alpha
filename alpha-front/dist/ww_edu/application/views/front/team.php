		<div id="content">
			<div class="core-feats2">
				<div class="container">
					<h1 class="maintitle white-color">维望团队</h1>
					<div class="mainborder"></div>
					<p class="mainsubtitle">没有完美的个人，只有完美的团队。由国内外资深投资专家及高端专业人才组成的维望团队，放眼世界，环球理财，把维望打造成中国最具有价值的金融平台，梦想与奇迹同在，财富与机遇并存。在这里，我们不仅看到了为梦想不懈努力的人，更看了一种“敢为人先”的城市精神，文化凝聚人才，团队早就梦想，人才作为我公司生存发展树立品牌的第一要素，奠定了我们人才强企的根基。</p>
				</div>
			</div>
			<!-- End Core-feats2 -->

			<div class="love2">
				<div class="container">
					<h1 class="maintitle white-color">客户利益至上 实现多赢共享</h1>
					<a href="<?=site_url(array('home','contact'))?>" class="button-white">联系维望<i class="fa fa-arrow-circle-o-right"></i></a>
				</div>
			</div>
			<!-- End Love2 -->

			<div class="about-agency">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
                            <h1 class="leftmain-title brown-color">维望市场运营团队</h1>
							<div class="leftmain-border brown-bd"></div>
                            <p>我们了解客户需求，尊重客户需要，维望每一个项目都去开门迎路，把握市场先机，掌握第一手资源。我们孜孜不倦的追求精神，不断创新，抓住契机乘胜而上。艰难困苦，玉汝于成，我们迈着坚定的步伐在前进,维望与你志同道合，共建财富未来。</p><br/><br/>
                            
                            <h1 class="leftmain-title brown-color">维望技术团队</h1>
							<div class="leftmain-border brown-bd"></div>
                            <p>团队秉承传统的交易思维理念，拥有先进的基础硬件设施，掌握成熟健全的交易系统、运用丰富的资金管理经验以及稳定的投资回报业绩以及先进的风险控制机制。团队已先后成功研发出十数套成熟稳定的交易策略，在保证资金稳定运行和风险可控的基础上追求投资回报的最大化，并且获取了可观的投资回报。</p>

						</div>
						<div class="col-md-6">
							<div class="skills-progress">
							<h1 class="leftmain-title">维望业绩</h1>
							<div class="leftmain-border"></div>
							
							<div class="skill-item">
								<p>2012 <span>33%</span></p>
								<div class="meter nostrips">
									<span style="width: 33%"></span>
								</div>
							</div>

							<div class="skill-item">
								<p>2013 <span>42%</span></p>
								<div class="meter nostrips">
									<span style="width: 42%"></span>
								</div>
							</div>
						
							<div class="skill-item">
								<p>2014 <span>37%</span></p>
								<div class="meter nostrips">
									<span style="width: 37%"></span>
								</div>
							</div>

							<div class="skill-item">
								<p>2015 <span>45%</span></p>
								<div class="meter nostrips">
									<span style="width: 45%"></span>
								</div>
							</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End About Agency -->

		</div>
		<!-- End content -->

		<!-- End Love -->

		

		<!-- End Love -->

			

	<!--
	##############################
	 - ACTIVATE THE BANNER HERE -
	##############################
	-->
	<script type="text/javascript">

		var tpj=jQuery;
		tpj.noConflict();

		tpj(document).ready(function() {

		if (tpj.fn.cssOriginal!=undefined)
			tpj.fn.css = tpj.fn.cssOriginal;

			var api = tpj('.fullwidthbanner').revolution(
				{
					delay:8000,
					startwidth:1170,
					startheight:700,

					onHoverStop:"off",						// Stop Banner Timet at Hover on Slide on/off

					thumbWidth:100,							// Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
					thumbHeight:50,
					thumbAmount:3,

					hideThumbs:0,
					navigationType:"bullet",				// bullet, thumb, none
					navigationArrows:"solo",				// nexttobullets, solo (old name verticalcentered), none

					navigationStyle:"round",				// round,square,navbar,round-old,square-old,navbar-old, or any from the list in the docu (choose between 50+ different item), custom


					navigationHAlign:"center",				// Vertical Align top,center,bottom
					navigationVAlign:"bottom",					// Horizontal Align left,center,right
					navigationHOffset:30,
					navigationVOffset: 40,

					soloArrowLeftHalign:"left",
					soloArrowLeftValign:"center",
					soloArrowLeftHOffset:40,
					soloArrowLeftVOffset:0,

					soloArrowRightHalign:"right",
					soloArrowRightValign:"center",
					soloArrowRightHOffset:40,
					soloArrowRightVOffset:0,

					touchenabled:"on",						// Enable Swipe Function : on/off


					stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
					stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

					hideCaptionAtLimit:0,					// It Defines if a caption should be shown under a Screen Resolution ( Basod on The Width of Browser)
					hideAllCaptionAtLilmit:0,				// Hide all The Captions if Width of Browser is less then this value
					hideSliderAtLimit:0,					// Hide the whole slider, and stop also functions if Width of Browser is less than this value


					fullWidth:"on",

					shadow:1								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows -  (No Shadow in Fullwidth Version !)

				});


				// TO HIDE THE ARROWS SEPERATLY FROM THE BULLETS, SOME TRICK HERE:
				// YOU CAN REMOVE IT FROM HERE TILL THE END OF THIS SECTION IF YOU DONT NEED THIS !
					api.bind("revolution.slide.onloaded",function (e) {


						jQuery('.tparrows').each(function() {
							var arrows=jQuery(this);

							var timer = setInterval(function() {

								if (arrows.css('opacity') == 1 && !jQuery('.tp-simpleresponsive').hasClass("mouseisover"))
								  arrows.fadeOut(300);
							},3000);
						})

						jQuery('.tp-simpleresponsive, .tparrows').hover(function() {
							jQuery('.tp-simpleresponsive').addClass("mouseisover");
							jQuery('body').find('.tparrows').each(function() {
								jQuery(this).fadeIn(300);
							});
						}, function() {
							if (!jQuery(this).hasClass("tparrows"))
								jQuery('.tp-simpleresponsive').removeClass("mouseisover");
						})
					});
				// END OF THE SECTION, HIDE MY ARROWS SEPERATLY FROM THE BULLETS
			});
	</script>