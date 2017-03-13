		<div id="content" >
			<div class="flexslider">
				<ul class="slides">
					<li>
						<img alt="" src="<?=base_url()?><?=STATIC_UPLOAD_IMG?>portd1.jpg" />
					</li>
					<li>
						<img alt="" src="<?=base_url()?><?=STATIC_UPLOAD_IMG?>portd2.jpg" />
					</li>
				</ul>
			</div>
			<!-- End port details extended -->	

			<div class="brief">
				<div class="container">
					<div class="col-md-8">
						<h1 class="leftmain-title">维望介绍</h1>
						<div class="leftmain-border"></div>

						<p>维望在2009年由王建都先生于英国创建，并成为首家获得英国金融服务监管局（FCA）授权的华人金融服务机构。公司总部位于全球金融中心伦敦Canary Wharf（高盛、摩根等世界顶级投行总部所在区）。</p>
						<p>维望资产管理有限公司成立于2011年，秉承为全球金融机构提供专业全面的技术服务。为高净值人群（HNW）提供投资管理和顾问服务。</p>
                        <p>维望于2014年完成全球资源整合以及未来布局。于英属维京群岛成立维望控股有限公司WEWANT Holdings Ltd 作为欧洲对冲基金总部，以英国伦敦为技术支持核心，为维望提供世界顶尖金融人才和信息资源。</p>
                        <p>在亚洲，我们设立维望资本集团（香港）有限公司，致力于为亚洲各大新兴经济体和金融机构提供全球最领先的交易平台服务；</p>
                        <p>维望（上海）股权投资基金管理有限公司和维望资产管理有限公司，作为专业资产管理机构携手国内外具有丰富金融市场经验的精英团队服务于各大金融机构。</p>
                        <p>2014年底，维望正式登记备案成为中国基金业协会认可的私募基金投资管理人。主要业务包括：私募基金管理，天使A轮投资，股权投资，为全球各大交易市场提供交易订单（证券订单，商品期货订单，商品期权等等）。维望以专业的投资策略、研发体系、风控制度，更高效稳健的服务于全球华人。</p>
					</div>
					<div class="col-md-4">
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
			<!-- End brief -->

			<div class="piechart">
				<div class="container">
					<h1 class="maintitle white-color">FOF全球配置</h1>
                    <br/>
					<p class="mainsubtitle">基金中的基金目的在于将市面上的基金和自己管理的基金再做一次组合，并且进行全球智能资产配置：从FOF中分配资金投入到基金中，低风险稳定收益类放大杠杆，高风险高收益类减少投资比例；为了进一步分散风险，通过选择优秀的基金以优化的比例组合起来，在尽量保证收益的前提下，将波动降下来。为何进行全球配置？2015年是一个例子，在选择单一国市场指数为主的ETF为子基金，难免受到其系统性风险的冲击。</p>
				</div>
			</div>

			<!-- End Love -->


     <!-- jQuery KenBurn Slider  -->


	<script>

		var doughnutData = [
				{
					value: 300,
					color:"#285fdb",
					highlight: "#285fdb",
					label: "Creativeness"
				},
				{
					value: 50,
					color: "#28dbc4",
					highlight: "#28dbc4",
					label: "Photoshop"
				},
				{
					value: 100,
					color: "#b4dd44",
					highlight: "#b4dd44",
					label: "Wordpress"
				},
				{
					value: 70,
					color: "#ebb72b",
					highlight: "#ebb72b",
					label: "Marketing"
				}

			];

			window.onload = function(){
				var ctx = document.getElementById("chart-area").getContext("2d");
				window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});
			};



	</script>

