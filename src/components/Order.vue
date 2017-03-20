<template>
	<div class="order-box">
		<div ref="pay_deal" v-if="show_pay_deal" class="pay-deal-mask">
			<div class="pay-deal">
				Processing…………
			</div>
		</div>
		<div class="order-header">
			<ul class="order-title">
				<li v-for="item in tabs">
					<router-link  active-class="active" :to="item.link" >{{item.title}}</router-link>
				</li>
			</ul>
			<input class="order-search" type="text" placeholder="输入活动名称">
		</div>
		<router-view class="order-body"></router-view>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				orders: [],
				show_act: true,
				show_z: false,
				show_zp: false,
				show_pay_deal: false,
				tabs: [
					{ title: 'Event Order', link: '/personal/order/event_order' },
					{ title: 'Tr Fl Order', link: '/personal/order/tr_fl_order' },
					{ title: 'Zone Plus Order',link: '/personal/order/zone_plus_order' }
				]
			}
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.order-box{
		padding: 20px 0;
		.pay-deal-mask{
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background: rgba(0,0,0,.5);
			.pay-deal{
				position: absolute;
				left: 50%;
				top: 100px;
				margin-left: -250px;
				width: 500px;
				height: 200px;
				background: #fff;
				border-radius: 3px;
				text-align: center;
				line-height: 200px;
				box-shadow: 0 0 50px 18px rgba(0,0,0,.2);
			}
		}
		.order-header{
			width: 100%;
			overflow: hidden;
			.order-title{
				float: left;
				margin-top: 10px;
				border-left: 2px solid $primary;
				color: $gray2;
				font-size: 14px;
				padding-left: 5px;
				cursor: pointer;
				li{
					float: left;
					margin-right: 20px;
					a{
						color:$gray1;
						text-decoration: none;
					}
					&:hover,&:focus{
						color:$primary;
					}
					.active{
						color: $primary !important;
					}
				}
			}
			.order-search{
				float: right;
				width: 200px;
				height: 32px;
				border: 1px solid $gray5;
				color: $gray3;
				padding: 0 15px;
				line-height: 32px;
				border-radius: 3px;
				outline: none;
				box-sizing: border-box;
			}
		}
		.order-body{
			width: $boxwidth;
			margin: 0 auto;
			overflow: hidden;
		}
	}
</style>