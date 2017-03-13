<template>
	<div class="header-mask">
		<Login v-if="$store.state.show_login"></Login>
		<Register v-if="$store.state.show_register"></Register>
		<div class="header-box">

			<router-link to="/" class="header-logo">
				<i class="header-logo-img"></i>
			</router-link>

			<ul class="header-navs">
				<router-link class="header-nav" v-for="item in navs" :to="item.link">
					<i class="header-nav-icon"></i>
					<span class="header-nav-text">
						{{item.text}}
					</span>
				</router-link>
			</ul>

			<div class="header-option">
				<div class="header-user" v-show="!$store.state.is_online" @click="openLogin">
					Login in/Register
				</div>
				<router-link class="header-user" v-show="$store.state.is_online" @click="openLogin" to="/personal/profile">
					{{$store.state.nic_name}}
				</router-link>
				<router-link  class="header-face" @click="openLogin" to="/personal/profile">
					<img src="../assets/images/photo.jpg" alt="">
				</router-link>
				<div class="header-lang">
					
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
				// nic_name: 'John Smith',
				navs: [
					{ text: 'Alpha Zone',icon: '', link: '/zone' },
					{ text: 'Alpha Zone+',icon: 'floor', link: '/zoneplus' },
					{ text: 'Alpha Event',icon: 'event', link: '/act' },
					{ text: 'Alpha Tv',icon: 'tv', link: '/tv_list' },
					{ text: 'About Us',icon: 'about', link: '' }
				]
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
		methods: {
			openLogin() {
				if(sessionStorage.getItem('token')==''||sessionStorage.getItem('token')==undefined){
					let self = this
					self.$store.dispatch('TOGGLELOGIN','on')
				}else{
					self.$router.push({path: '/personal/profile'})
				}
				
			}
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.header-mask{
		width: 100%;
		height: $headerheight;
		background-color:$gray1;
		overflow: hidden;
      	position: relative;
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
					color: rgba(255,255,255,.7);
					height: 100%;
					font-size: 14px;
					cursor: pointer;
					transition: all .2s;
					&:hover,&:focus{
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
					&:hover,&:focus{
						.header-nav-icon{
							background-image: url(../assets/images/topbar_zone_s.png);
						}
					}
				}
				.header-nav:nth-child(2){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_zone+.png);
					}
					&:hover,&:focus{
						.header-nav-icon{
							background-image: url(../assets/images/topbar_zone+_s.png);
						}
					}
				}
				.header-nav:nth-child(3){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_event.png);
					}
					&:hover,&:focus{
						.header-nav-icon{
							background-image: url(../assets/images/topbar_event_s.png);
						}
					}
				}
				.header-nav:nth-child(4){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_tv.png);
					}
					&:hover,&:focus{
						.header-nav-icon{
							background-image: url(../assets/images/topbar_tv_s.png);
						}
					}
				}
				.header-nav:nth-child(5){
					.header-nav-icon{
						background-image: url(../assets/images/topbar_about.png);
					}
					&:hover,&:focus{
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
				.header-user{
					float: left;
					padding: 0 8px;
					cursor: pointer;
				}
				.header-face{
					float: left;
					padding: 0 10px;
					box-sizing: border-box;
					&>img{
						border: 1px solid #fff;
						border-radius: 50%;
						width: 30px;
						height: 30px;
						margin-top: 15px;
						display: inline-block;
						background-color: #fff;
						box-sizing: border-box;
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
				}
			}
		}	
	}
	
</style>