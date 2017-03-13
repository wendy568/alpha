<template>
	<div class="per-box">
		<div class="per-header">
			<div class="per-portrait">
				<img class="per-portrait-img" :src="user_face" alt="">
				<p class="per-nicname">
					{{$store.state.nic_name}}
				</p>
			</div>
			<div class="per-tabs-box">
				<ul class="per-tabs">
					<li class="per-tabs-item" v-for="item in tabs">
						<router-link active-class="active" :to="item.link" style="color: #fff;text-decoration: none;" >
							<i class="per-tabs-item-icon"></i>
							<span class="per-tabs-item-title">{{item.title}}</span>
						</router-link>
					</li>
				</ul>	
			</div>
		</div>
		<router-view class="per-body"></router-view>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user_face: '../assets/images/portrait.jpg',
				nic_name: 'Jay Zhou',
				tabs: [
					{ title: 'profile',icon: '../assets/images/user.png', link: '/personal/profile' },
					{ title: 'video',icon: '../assets/images/favorite.png', link: '/personal/favorite' },
					{ title: 'order',icon: '../assets/images/order.png', link: '/personal/order' }
				]
			}
		},
		mounted() {
			const self = this
			
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.active{
		color: $primary !important;
		border-bottom: 2px solid $primary;
	}
	.per-box{
		float: left;
		width: 100%;
		overflow: hidden;
		.per-header{
			position: relative;
			float: left;
			width: 100%;
			height: 220px;
			background-image: url(../assets/images/personal.png);
			background-position: center center;
			background-repeat: no-repeat;
			.per-portrait{
				width: 100%;
				overflow: hidden;
				float: left;
				padding: 30px 0;
				.per-portrait-img{
					overflow: hidden;
					border-radius: 50%;
					width: 100px;
					height: 100px;
					margin: 0 auto;
					display: block;
					border: 4px solid rgba(255,255,255,.2);
				}
				.per-nicname{
					margin: 0;
					margin-top: 10px;
					width: 100%;
					text-align: center;
					color: #fff;
					font-size: 20px;
					font-style: italic;
				}
			}
			.per-tabs-box{
				position: absolute;
				left: 0;
				bottom: 0;
				width: 100%;
				float: left;
				box-sizing: border-box;
				.per-tabs{
					width: 500px;
					margin: 0 auto;
					padding: 0;
					.per-tabs-item{
						font-size: 16px;
						color: #fff;
						float: left;
						width: 25%;
						margin-right: 12.5%;
						text-align: center;
						cursor: pointer;
						padding-bottom: 7px;
						a{
							padding-bottom: 5px;
						}
						&:last-child{
							margin-right: 0;
						}
						&:hover{
							color: $primary;
						}
						.per-tabs-item-icon{
							width: 18px;
							height: 18px;
							display: inline-block;
							background-repeat: no-repeat;
							background-position: center center;
							background-size: 100%;
						}
						.per-tabs-item-title{
							letter-spacing: .8px;
							line-height: 16px;
							position: relative;
							bottom: 4px;
						}
					}
					.per-tabs-item:nth-child(1){
						&:hover{
							.per-tabs-item-icon{
								background-image: url(../assets/images/user_hover.png);
							}	
						}
						.per-tabs-item-icon{
							background-image: url(../assets/images/user.png);
						}
					}
					.per-tabs-item:nth-child(2){
						&:hover{
							.per-tabs-item-icon{
								background-image: url(../assets/images/favorite_hover.png);
							}	
						}
						.per-tabs-item-icon{
							background-image: url(../assets/images/favorite.png);
						}
					}
					.per-tabs-item:nth-child(3){
						&:hover{
							.per-tabs-item-icon{
								background-image: url(../assets/images/order_hover.png);
							}	
						}
						.per-tabs-item-icon{
							background-image: url(../assets/images/order.png);
						}
					}
				}	
			}
			
		}
		.per-body{
			width: $boxwidth;
			margin: 0 auto;
			overflow: hidden;
		}
	}
</style>