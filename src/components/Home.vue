<template>
	<div class="home-box">

		<act_form v-if="$store.state.show_actform"></act_form>
		<act_pay v-if="$store.state.show_actpay"></act_pay>

		<div class="section-mask">
			<div class="section-zone">
				<ul class="zone-box">
					<li class="zone-item" v-for="item in zone_list">
						<div class="zone-item-mask">
							<p class="zone-item-top"></p>
							<p class="zone-item-name">
								{{item.name}}
							</p>
							<p class="zone-item-des">
								{{item.des}}
							</p>
							<p class="zone-item-option">
								<router-link :to="item.link" class="zone-item-start">
									Get started
								</router-link>
							</p>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!-- 视频	 -->
		<div class="video-box">
			<div class="video-header">
				<div class="video-header-box">
					<h3 class="video-header-text">HOT VIDEOS</h3>
					<div class="video-header-bottom"></div>	
					<i class="video-header-dot"></i>
				</div>
			</div>
			<ul class="video-list">
				<li class="video-item" v-for="item in videos" >
					<img class="video-item-img" :src="item.image" alt="">
					<div class="video-item-mask" @click="viewVideo(item.id)">
						<!-- 视频开始按钮 -->
						<span class="video-item-play" ></span>
						<!-- 视频时长 -->
						<span class="video-item-time">{{item.length}}</span>
					</div>
					<div class="video-item-info">
						<div class="video-item-top">
							<p class="video-item-title">
								{{item.name}}
							</p>
							<p class="video-item-data">
								<span class="create_time">
									<i></i>
									{{item.create_time}}
								</span>
								<!-- <span class="video-item-like">
									<i :class="{active:isActive}" class="unlike"></i>
									{{item.like}}
								</span> -->
								<span class="video-item-comment">
									<i></i>
									{{item.comment_count}}
								</span>
							</p>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<!-- event -->
		<div class="event-box">
			<div class="event-header">
				<div class="event-header-box">
					<h3 class="event-header-text"> HOT EVENTS </h3>
					<div class="event-header-bottom"></div>
					<i class="event-header-dot"></i>	
				</div>
			</div>
			<ul class="event-list">
				<li class="event-item" v-for="item in events">
			
					<div class="event-item-img" @click="openActForm">
						<div class="event-item-img-mask">
							<img src="../assets/images/act1.jpg" alt="">
						</div>
					</div>

					<div class="event-item-info">
						<h3 class="event-item-info-title" @click="openActForm">
							{{item.name}}
						</h3>
						<p class="event-item-info-des">
							Description：{{item.des}}
						</p>
						<p class="event-item-info-length">
							<i></i>
							{{item.length}}
						</p>
						<p class="event-item-info-place">
							<i></i>
							{{item.place}}
						</p>

						<button @click="openActForm" class="btn-primary"> Apply </button>
					</div>

					<span class="event-item-status badge-success">{{item.status}}</span>

				</li>
			</ul>
		</div>

		<div class="home-header-datas">
			<div class="home-header-data">
				<ul class="home-header-data-box">
					<li class="home-header-data-item" v-for="item in datas">
						<p class="home-header-data-item-icon">
							<i class="home-header-data-icon"></i>
						</p>
						<p class="home-header-data-count">
							{{item.count}}
						</p>
						<p class="home-header-data-name">
							{{item.name}}
						</p>
					</li>
				</ul>
			</div>
		</div>

		<div class="copyright">
			<div class="text">上海alpha科技股份有限公司&copy版权所有，沪ICP备139475427号</div>
		</div>

	</div>
</template>

<script>
	import Datepicker from 'vue-datepicker'
	export default {
		data() {
			return {
				datas: [
					{ name: 'Total Desk',count: 9587,icon: 'desk' },
					{ name: 'Setties',count: 955,icon: 'flag' },
					{ name: 'Trader Program',count: 579,icon: 'balloon' },
					{ name: 'Events',count: 1358,icon: 'count' }
				],
				videos: [
				],
				events: [
					{ month: '8',day: '12',image: '../assets/images/act1.jpg',name: 'N+X炒鸡路演|攀谈会：风口上的网红经济',des: '当老牌网红遭遇新晋小生',length: '2016-10-23 12:00 至 2016-10-24 18:00',place: 'SOHO 北京-银河 1层',status: '报名中' },
					{ month: '8',day: '12',image: '../assets/images/act2.jpg',name: 'N+X炒鸡路演|攀谈会：风口上的网红经济',des: '当老牌网红遭遇新晋小生',length: '2016-10-23 12:00 至 2016-10-24 18:00',place: 'SOHO 北京-银河 1层',status: '报名中' }
				],
				zone_list: [
					{ name: 'ZONE',des: 'Profession Environment Advanced Equipment Best Communication Space',link: '/zone' },
					{name: 'ZONE+',des: 'Improve Rapidly Online and Offline Service Theory combined with practice',link: '/zoneplus' }
				],
				isActive:false
			}
		},
		mounted() {
			const self = this
			fetch(self.$store.state.api_addr + 'video/list',{
			 	method: 'post',
			 	headers: {
			 		'Content-Type': 'application/x-www-form-urlencoded'
			 	},
			 	body: 'limit=' + 4 + '&start=' + 0
			}).then((res) => {
				res.ok && res.json().then((json) => {
						self.videos = json.data
						for(let i = 0;i < self.videos.length;i ++){
							if(self.videos[i].image !== null || self.videos[i].image !== "" || self.videos[i].image !== undefined){
								self.videos[i].image = self.$store.state.api_addr + 'upload/' + self.videos[i].image[0] + 'm_' + self.videos[i].image[1]	
							}else{
								self.videos[i].image = 'http://content.jwplatform.com/thumbs/' + self.videos[i].source + '-320.jpg'	
							}
						}				
					})
				}
			)
		},
		components: {
			'date-picker': Datepicker,
			'act_form': function(resolve) {
				require(['./Act_form'], resolve)
			},
			'act_pay': function(resolve) {
				require(['./Act_pay'], resolve)
			}
		},
		methods: {
			viewVideo(id) {
				const self = this
				if(sessionStorage.getItem('token')){
					let formData = new FormData()
					formData.append('id',id)
					formData.append('token',sessionStorage.getItem('token'))
					fetch(self.$store.state.api_addr + 'index.php/video/views_history_mark',{
						method: 'post',
						mode: 'cors',
						body: formData
					}).then((res) => {
						
					})
				}
				self.$router.push({path: '/tv_detail',query: { id: id }})
			},
			openActForm() {
				const self = this
				self.$router.push({path: '/act_detail'})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import '../css/alpha.scss';
	::-webkit-input-placeholder { /* WebKit browsers */ 
		color: $primary; 
	} 
	:-moz-placeholder { /* Mozilla Firefox 4 to 18 */ 
		color: $primary; 
	} 
	::-moz-placeholder { /* Mozilla Firefox 19+ */ 
		color: $primary; 
	} 
	:-ms-input-placeholder { /* Internet Explorer 10+ */ 
		color: $primary; 
	} 
	.home-box{
		width: 100%;
		overflow: hidden;
		.section-mask{
			width: 100%;
			height: 460px;
			margin-top: 30px;
			box-sizing: border-box;
			.section-zone{
				width: 1140px;
				height: 460px;
				margin:0 auto;
				.zone-box{
					width: 100%;
					overflow: hidden;
					margin: 0;
					padding: 0;
					.zone-item{
						float: left;
						width: 50%;
						overflow: hidden;
						height: 460px;
						.zone-item-mask{
							width: 100%;
							height: 100%;
							text-align: center;
							padding: 100px 185px;
							box-sizing: border-box;
							transition: all .35s;
							.zone-item-name{
								margin: 0 0 15px 0;
								font-size: 40px;
							}
							.zone-item-des{
								margin: 0;
								font-size: 13px;
								line-height: 1.5;
							}
							.zone-item-option{
								margin: 40px 0;
								.zone-item-start{
									cursor: pointer;
									outline: none;
									display: inline-block;
									text-align: center;
									text-decoration: none;
									line-height: 40px;
								}
							}
						}
						&:nth-child(1){
							background:url(../assets/images/alpha_image_index_zone.png)  center center no-repeat;
							background-size: 100%;
							.zone-item-mask{
								background:rgba(211,184,139,.8);
								color: #fff;
								&:hover{
									background: rgba(211,184,139,.5);
								}
								.zone-item-top{
									width: 55px;
									height: 55px;
									margin:0 auto;
									display: block;
									background:url(../assets/images/index_zone.png)  no-repeat;
									background-size: 100% 100%;
								}
								.zone-item-option{
									.zone-item-start{
									    width: 150px;
										height: 40px;
										background: transparent;
										color: #fff;
										border: 1px solid #fff;
										border-radius: 2px;
										transition: all .2s;
										&:hover{
											background: #fff;
											color: $primary;
										}
									}
								}
							}
						}
						&:nth-child(2){
							background:url(../assets/images/alpha_image_index_zone+.png) center center no-repeat;
							background-size: 100%;
							.zone-item-mask{
								color: $primary;
								background: rgba(0,0,0,.8);
								&:hover{
									background: rgba(0,0,0,.5)
								}
								.zone-item-top{
									height: 55px;
									width: 55px;
									display: block;
									margin:0 auto;
									background:url(../assets/images/index_zone+.png) no-repeat;
									background-size: 100% 100%;
								}
								.zone-item-option{
									.zone-item-start{
										width: 150px;
										height: 40px;
										background: transparent;
										color: $primary;
										border: 1px solid $primary;
										border-radius: 2px;
										transition: all .2s;
										&:hover{
											background: $primary;
											color: rgba(0,0,0,.5);
											transition: all .4s; 
										}
									}
								}
							}
						}
					}
				}
			}
		}
		// video
		.video-box{
			width: $boxwidth;
			overflow: hidden;
			margin: 0 auto;
			padding: 30px 0;
			box-sizing: border-box;
			.video-header{
				width: 100%;
				height: 50px;
				padding-bottom: 20px;
				.video-header-box{
					height: 100%;
					color: $primary;
					margin: 0 auto;
					display: table;
					position: relative;
					.video-header-text{
						margin: 0 auto;
						text-align: center;
						font-size: 20px;
						padding-bottom: 8px;
						font-weight: 400;
						border-bottom: 1px solid $primary;
						letter-spacing: .8px;
					}
					.video-header-bottom{
						
					}
					.video-header-dot{
						position: absolute;
						bottom: 14px;
						width: 8px;
						height: 8px;
						background-color: $primary;
						left: 50%;
						margin-left: -5px;
					}
				}
				
			}
			.video-list{
				width: $boxwidth + 40;
				position: relative;
				left: -10px;
				margin: 0 auto;
				overflow: hidden;
				float: left;
				padding: 0;
				.video-item{
					position: relative;
					width: $boxwidth/4 - 15;
					margin-left: 10px;
					margin-right: 10px;
					margin-bottom: 20px;
					float: left;
					box-sizing: border-box;
					transition: all .35s;
					&:hover{
                        box-shadow: 0 0 15px rgba(0,0,0,.18);
                    }
					.video-item-img{
						float: left;
						width: 100%;
						height: 160px;
						background-color: #ccc;
					}
					.video-item-mask{
						position: absolute;
						left: 0;
						top: 0;
						width: 100%;
						height: 160px;
						.video-item-play{
							position: absolute;
							left: 0;
							top: 0;
							width: 100%;
							height: 100%;
							background-position: center center;
							background-size: 15%;
							background-repeat: no-repeat;
							cursor: pointer;
							&:hover{
								background-image: url(../assets/images/play.png);
							}
							&:active{
								background-image: url(../assets/images/play_hover.png);
							}
						}
						.video-item-time{
							width: 35px;
							height: 24px;
							position: absolute;
							font-size: 14px;
							line-height: 24px;
							right: 25px;
							top: 15px;
							color: #fff;
							padding: 0 10px;
							border-radius: 15px;
							background-color: rgba(0,0,0,.3);
						}
					}
					.video-item-info{
						width: 100%;
						float: left;
						border: 1px solid $gray5;
						box-sizing: border-box;
						.video-item-top{
							box-sizing: border-box;
							padding: 10px 10px 0px 10px;
							height: 75px;
							.video-item-title{
								margin: 0;
								color: $gray1;
								font-size: 14px;
								overflow: hidden;
								height: 52px;
								cursor: pointer;
								&:hover{
									color:$primary;
									transition: all .2s; 
								}
							}
							.video-item-data{
								color: $gray3;
								font-size: 12px;
								height: 24px;
								margin:3px 0;
								line-height: 24px;
								.create_time{
									height: 24px;
									width: 160px;
									line-height: 24px;
									float: left;
									color: $gray3;
									box-sizing: border-box;
									font-size: 12px;
									i{
										float: left;
										width: 24px;
										height: 24px;
										background:url(../assets/images/video_list_time.png) left center no-repeat;
										background-size:50% 50%;
									}
								}
								.video-item-comment{
									float: right;
									i{
										float: left;
										width: 24px;
										height: 24px;
										background:url(../assets/images/video_list_comment.png) center center no-repeat;
										background-size:50% 50%;
									}
								}
								// .video-item-like{
								// 	float: right;
								// 	cursor: pointer;
								// 	.unlike{
								// 		float: left;
								// 		width: 24px;
								// 		height: 24px;
								// 		background:url(../assets/images/video_list_like.png) center center no-repeat;
								// 		background-size:50% 50%;
								// 		&:hover,&.active{
								// 			background:url(../assets/images/video_list_like_s.png) center center no-repeat;
								// 			background-size:50% 50%;
								// 			cursor: pointer;
								// 		}
								// 	}
								// }
							}
						}
					}
				}
				.video-item:nth-child(4n){
					padding-right: 0;
				}
			}
		}
		// event
		.event-box{
			width: $boxwidth;
			overflow: hidden;
			margin: 0 auto;
			padding: 30px 0;
			box-sizing: border-box;
			.event-header{
				width: 100%;
				height: 50px;
				padding-bottom: 20px;
				.event-header-box{
					height: 100%;
					color: $primary;
					margin: 0 auto;
					display: table;
					position: relative;
					.event-header-text{
						margin: 0 auto;
						font-size: 20px;
						text-align: center;
						padding-bottom: 8px;
						font-weight: 400;
						border-bottom: 1px solid $primary;
						letter-spacing: .8px;
					}
					.event-header-bottom{
						
					}
					.event-header-dot{
						position: absolute;
						bottom: 14px;
						width: 8px;
						height: 8px;
						background-color: $primary;
						left: 50%;
						margin-left: -5px;
					}
				}
				
			}
			.event-list{
				width: 100%;
				margin: 0 auto;
				overflow: hidden;
				float: left;
				padding: 0;
				.event-item{
					width: 100%;
					height: 160px;
					overflow: hidden;
					margin-bottom: 35px;
					position: relative;	
					.event-item-img{
						float: left;
						width: 270px;
						height: 100%;
						cursor: pointer;
						.event-item-img-mask{
							background-color: #999;
							width: 100%;
							height: 100%;
							border-radius: 2px;
							img{
								width: 100%;
								height: 100%;
							}
						}
					}
					.event-item-info{
						padding-left: 25px;
						float: left;
						color: $font;
						position: relative;
						font-size: 12px;
						height: 100%;
						.event-item-info-title{
							padding: 0;
							margin: 0;
							font-size: 16px;
							color: #343c4d;;
							padding-bottom: 20px;
							cursor: pointer;
							&:hover{
								color:$primary;
								transition: all .2s; 
							}
						}
						.event-item-info-des{
							margin: 0;
							padding-bottom: 15px;
						}
						.event-item-info-length{
							margin: 0;
							padding-bottom: 5px;
							height: 24px;
							line-height: 24px;
							i{
								float: left;
								width: 24px;
								height: 24px;
								margin-left: -4px;
								background:url(../assets/images/alpha_icon_apply_date.png) center center no-repeat;
								background-size:50% 50%;
							}
						}
						.event-item-info-place{
							margin: 0;
							padding-bottom: 15px;
							height: 24px;
							line-height: 24px;
							i{
								float: left;
								width: 24px;
								height: 24px;
								margin-left: -4px;
								background:url(../assets/images/alpha_icon_apply_location.png) center center no-repeat;
								background-size:50% 50%;
							}
						}
					}
					.event-item-status{
						position: absolute;
						font-size: 14px;
						right: 8px;
						top: 0;
					}
				}
			}
		}
		.home-header-datas{
			width: 100%;
			overflow: hidden;
			margin: 0 auto;
			border-top: 1px solid $gray5;
			background: url(../assets/images/index_statistic_bg.png);
			background-size: 100% 100%;
			.home-header-data{
				overflow: hidden;
				box-sizing: border-box;
				width:100%;
				height: 220px;
				color: #fff;
				background-color: rgba(0,0,0,.95);
				.home-header-data-box{
					position: relative;
					width: $contentwidth;
					height: 100%;
					margin: 0 auto;
					padding: 0;
					.home-header-data-item{
						float: left;
						width: 25%;
						padding-top: 40px;
						&:hover{
							transform: rotateX(10deg);
						}
						.home-header-data-item-icon{
							width: 100%;
							float: left;
							margin: 0 auto;
							text-align: center;
							.home-header-data-icon{
								display: inline-block;
								width: 65px;
								height: 65px;
								background-repeat: no-repeat;
								background-position: center center;
								background-size: 50%;
								border: 1px solid $primary;
								border-radius: 50%;
							}
						}
						.home-header-data-count{
							width: 100%;
							float: left;
							margin: 0;
							color: $primary;
							font-weight: 400;
							padding: 5px 0;
							font-size: 20px;
							text-align: center;
						}
						.home-header-data-name{
							color: $primary;
							width: 100%;
							font-size: 14px;
							float: left;
							margin: 0;
							text-align: center;
						}
					}
					.home-header-data-item:first-child{
						.home-header-data-icon{
							background-image: url(../assets/images/desk.png);
						}
					}
					.home-header-data-item:nth-child(2){
						.home-header-data-icon{
							background-image: url(../assets/images/chart.png);
						}
					}
					.home-header-data-item:nth-child(3){
						.home-header-data-icon{
							background-image: url(../assets/images/flag.png);
						}
					}
					.home-header-data-item:nth-child(4){
						.home-header-data-icon{
							background-image: url(../assets/images/balloon.png);
						}
					}
					.home-header-data-item:nth-child(5){
						.home-header-data-icon{
							background-image: url(../assets/images/count.png);
						}
					}
					.home-header-data-item:nth-child(6){
						.home-header-data-icon{
							background-image: url(../assets/images/flower.png);
						}
					}
				}
				
				
			}
		}
		.copyright{
			width: 100%;
			background-color: $gray1;
			height: 30px;
			.text{
				font-size: 12px;
				color: #454f4f;
				text-align: center;
				line-height: 30px;
			}
		}
	}
</style>