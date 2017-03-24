<template>
	<div class="header-mask">
		<Login v-if="$store.state.show_login"></Login>
		<Register v-if="$store.state.show_register"></Register>
		<div class="header-box">

			<router-link to="/" class="header-logo">
				<i class="header-logo-img"></i>
			</router-link>

			<ul class="header-navs">
				<li >
					<router-link class="header-nav "  :class='{active:isActvie}'
					v-for="item in navs" :to="item.link" >
						<span class="header-nav-icon "></span>
						<span class="header-nav-text ">
							{{item.text}}
						</span>
					</router-link>
				</li>
			</ul>

			<div class="header-option">
				<!-- 登录信息 -->
				<div class="header-user" v-show="!$store.state.is_online" @click="openLogin">
					Login in/Register
				</div>
				<!-- 头像 -->
				<a  class="header-face" @click="openLogin" v-show="$store.state.is_online">
					<img src="../assets/images/user_hover.png"  v-if="!$store.state.is_online" alt="">
					<img src="../assets/images/photo.jpg"  v-else alt="">
					<!-- 退出登录 -->
					<ul class="exit">
						<li>
							<router-link v-for="item in personal" :to="item.link">
								<i class="icon"></i>
								{{item.text}}
							</router-link>
						</li>
						<li>
							<a  @click="exit" style="color:red">
								<i class="icon"></i>
								exit
							</a>
						</li>
					</ul>
				</a>
				<!-- 中英文切换 -->
				<div class="header-lang">
					<ul class="lang">
						<li v-for="item in lang">
							<span>{{item.text}}</span>
						</li>
					</ul>
				</div>
				
			</div>
		</div>
	</div>
	
</template>

<script>
	import store from '../vuex/store'
	import tip from './Tip'
	export default {
		data() {
			return {
				navs: [
					{ text: 'Alpha Zone',icon: '', link: '/zone' },
					{ text: 'Alpha Zone+',icon: 'floor', link: '/zoneplus' },
					{ text: 'Alpha Event',icon: 'event', link: '/act' },
					{ text: 'Alpha Tv',icon: 'tv', link: '/tv_list' },
					{ text: 'About Us',icon: 'about', link: '/about' }
				],
				personal:[
					{text:'Userinfo',link: '/personal/profile'},
					{text:'My Profile',link: '/personal/favorite'},
					{text:'My Order',link: '/personal/order/event_order'}
				],
				lang:[
					{text:'English'},
					{text:'中文'}
				],
				isActvie:false
			}
		},
		components: {
			'Login': (resolve) => {
				require(['./Login'], resolve)
			},
			'Register': (resolve) => {
				require(['./Register'], resolve)
			}
		},
		mounted(){
			
		},
		methods: {
			openLogin() {
				if(sessionStorage.getItem('token')==''||sessionStorage.getItem('token')==undefined){
					let self = this
					self.$store.dispatch('TOGGLELOGIN','on')
				}else{

				}
			},
			exit(){
				let self = this
				self.$store.dispatch('UNLOADUSERINFO')
				self.$store.state.is_online=false
				self.$router.push({path:'/' })
			}
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.header-mask{
		width: 100%;
		background-color:$gray1;
		height: $headerheight;
		.header-box{
			width: 1140px;
			margin: 0 auto;
			.header-logo{
				float: left;
				width: 150px;
				height: $headerheight;
				.header-logo-img{
					background: url(../assets/images/alpha_logo.png) center center no-repeat;
					background-size: 100%;
					display: block;
					width: 100%;
					height: 100%;
				}
			}
			.header-navs{
				height: 100%;
				overflow: hidden;
				margin: 0;
				float: left;
				.header-nav{
					float: left;
					padding: 0 20px;
					color:#fff;
					opacity: 0.7;
					height: 100%;
					font-size: 14px;
					cursor: pointer;
					transition: all .2s;
					&:hover{
						background-color: rgba(255,255,255,.2);
						color: $primary;
					}
					.header-nav-icon{
						float: left;
						width: 18px;
						margin-right: 8px;
						height: $headerheight;
						background-repeat: no-repeat;
						background-position: center center;
						background-size: 100%;
						opacity: 0.7;
					}
					
					.header-nav-text{
						text-align: center;
						height: 100%;
						float: left;
						line-height: $headerheight;
					}
				}
				.header-nav:nth-child(1){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_zone.png);
					}
					&:hover,&.active{
						color:$primary;
						.header-nav-icon{
							background-image: url(../assets/images/topbar_zone_s.png);
						}
					}
				}
				.header-nav:nth-child(2){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_zone+.png);
					}
					&:hover,&.active{
						color:$primary;
						.header-nav-icon{
							background-image: url(../assets/images/topbar_zone+_s.png);
						}
					}
				}
				.header-nav:nth-child(3){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_event.png);
					}
					&:hover,&.active{
						color:$primary;
						.header-nav-icon{
							background-image: url(../assets/images/topbar_event_s.png);
						}
					}
				}
				.header-nav:nth-child(4){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_tv.png);
					}
					&:hover,&.active{
						color:$primary;
						.header-nav-icon{
							background-image: url(../assets/images/topbar_tv_s.png);
						}
					}
				}
				.header-nav:nth-child(5){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_about.png);
					}
					&:hover,&.active{
						color:$primary;
						.header-nav-icon{
							background-image: url(../assets/images/topbar_about_s.png);
						}
					}
				}
			}
			.header-option{
				float: right;
				height: $headerheight;
				color: $primary;
				line-height: $headerheight;
				font-size: 14px;
				position: relative;
				.header-user{
					float: left;
					padding: 0 8px;
					cursor: pointer;
				}
				.header-face{
					float: left;
					padding: 0 10px;
					box-sizing: border-box;
					position: relative;
					height: $headerheight;
					transform:all .5s;
					&:hover .exit{
						transition:all .5s;
						display: block;
					}
					&>img{
						border: 1px solid #fff;
						border-radius: 50%;
						width: 30px;
						height: 30px;
						margin-top: 20px;
						display: inline-block;
						background-color: #fff;
						box-sizing: border-box;
					}
					.exit{
						width: 120px;
						position: absolute;
						z-index: 1000;
						background-color:$gray1;
						top:50px;
						left:-90px;
						padding:10px;
						line-height: 25px;
						display: none;
						li{	
							width: 120px;
							a{
								color: rgba(255,255,255,.7);
								text-decoration: none;
								padding: 15px 5px;
								float: left;
								
								.icon{
									width: 20px;
									height: 20px;
									float: left;
									margin: 0 10px;
								}
								&:hover{
									color:$primary;
								}
								&:nth-child(1){
									.icon{
										background: url(../assets/images/user.png) center center no-repeat;
										background-size: 80%;
									}
									&:hover{
										.icon{
											background: url(../assets/images/user_hover.png) center center no-repeat;
											background-size: 80%;
										}
									}
								}
								&:nth-child(2){
									.icon{
										background: url(../assets/images/favorite.png) center center no-repeat;
										background-size: 80%;
									}
									&:hover{
										.icon{
											background: url(../assets/images/favorite_hover.png) center center no-repeat;
											background-size: 80%;
										}
									}
								}
								&:nth-child(3){
									.icon{
										background: url(../assets/images/order.png) center center no-repeat;
										background-size: 80%;
									}
									&:hover{
										.icon{
											background: url(../assets/images/order_hover.png) center center no-repeat;
											background-size: 80%;
										}
									}
								}
								&:nth-child(4){
									.icon{
										background: url(../assets/images/topbar_signout.png) center center no-repeat;
										background-size: 80%;
									}
									&:hover{
										.icon{
											background: url(../assets/images/topbar_signout_h.png) center center no-repeat;
											background-size: 80%;
										}
									}
								}
							}
						}
					}
				}
				.header-lang{
					margin-left: 8px;
					float: left;
					background-image: url(../assets/svg/earth.svg);
					width: 22px;
					height: 100%;
					background-size: 100%;
					background-position: center center;
					background-repeat: no-repeat;
					position: relative;
					&:hover .lang{
						transition:all .5s;
						display: block;
					}
					.lang{
						padding: 0;
						width: 100px;
						overflow: hidden;
						background-color: $gray1;
						position: absolute;
						top:56px;
						left:-78px;
						display: none;
						li{
							line-height: 25px;
							border-radius: 12px;
							margin:10px 10px;
							text-align: center;
							cursor: pointer;
							&:hover{
								color:$gray1;
								background-color: $primary;
							}
						}
					}
				}
			}
		}	
	}
	
</style>