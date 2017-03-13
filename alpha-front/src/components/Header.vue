<template>
	<div class="header-mask">
		<tip v-show="$store.state.tip.show"></tip>
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
				<div class="header-user" v-if="!$store.state.is_online" @click="openLogin">
					Login in/Register
				</div>
				<div class="header-user" v-else @click="openLogin">
					{{$store.state.nic_name}}
				</div>
				<router-link to="/personal/profile" class="header-face">
					<img :src="$store.state.user_face" alt="">
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
				nic_name: 'John Smith',
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
			},
			tip
		},
		methods: {
			openLogin() {
				let self = this
				self.$store.dispatch('TOGGLELOGIN','on')
			}
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.header-mask{
		width: 100%;
		height: $headerheight;
		background: linear-gradient(90deg, rgba(44,44,44,1) 0%, rgba(17,17,17,1) 100%);
		overflow: hidden;
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
					&:hover{
						background-color: rgba(255,255,255,.2);
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
						background-image: url(../assets/svg/floor.svg);
					}
				}
				.header-nav:nth-child(2){
					.header-nav-icon{
						background-image: url(../assets/svg/flag.svg);
					}
				}
				.header-nav:nth-child(3){
					.header-nav-icon{
						background-image: url(../assets/svg/tv.svg);
					}
				}
				.header-nav:nth-child(4){
					.header-nav-icon{
						background-image: url(../assets/svg/info.svg);
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
						border: 4px solid #fff;
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