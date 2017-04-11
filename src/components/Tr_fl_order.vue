<template>
	<div class="order-box">
		<ul class="order-table">
			<p class="order-table-header">
				<span class="order-table-header-order">订单商品</span>
				<span class="order-table-header-count">Count</span>
				<span class="order-table-header-total">Total</span>
				<span class="order-table-header-status">Status</span>
			</p>
			<li class="order-table-item" v-for="item in orders">
				<p class="order-table-item-header">
					<span class="order-table-item-header-order">
						订单编号:{{item.order}}
					</span>
					<span class="order-table-item-header-time">
						下单时间:{{item.create_time}}
					</span>
				</p>
				<div class="order-table-item-info">
					<img class="order-table-item-info-face" :src="item.src">
					<div class="order-table-item-info-content">
						<p class="order-table-item-info-name">
							{{item.name}}
						</p>
						<p class="order-table-item-info-des">
							Description: {{item.describe || 'Empty'}}
						</p>
						<p class="order-table-item-info-price">
							￡{{item.price}}
						</p>
					</div>
				</div>
				<div class="order-table-item-count">
					{{item.num}}
				</div>
				<div class="order-table-item-total">
					￡{{item.order_total_price}}
				</div>
				<div class="order-table-item-status">
					{{item.order_status | pay_status}}
				</div>
			</li>
		</ul>
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
				show_pay_deal: false
			}
		},
		filters: {
			pay_status(status) {
				if(status == 0){
					return 'Unpaid'
				}else if(status == 1){
					return 'Pay success'
				}else{
					return 'Pay failed'
				}
			}
		},
		methods: {
			
		},
		mounted() {
			const self = this
			let formData = new FormData()
			function showPayDeal() {
				self.show_pay_deal = true
				setTimeout(function() {
					self.$refs.pay_deal.style.display = 'none'
				},500)
			}
			location.href.split('?')[1] && sessionStorage.setItem('handle_params2',location.href.split('?')[1])
			location.href.split('?')[1] && showPayDeal()
			location.href.split('?')[1] && fetch(self.$store.state.api_addr + 'order/handler_order?' + sessionStorage.getItem('handle_params2'),{
				method: 'get'
			}).then((res) => {
				res.ok && res.json().then((json) => {
					sessionStorage.setItem('payment_token',json.payment_token)
					switch(json.archive.status){
						case 0:
							let formData = new FormData()
							formData.append('token',sessionStorage.getItem('token'))
							formData.append('status',1)
							formData.append('payment_token',sessionStorage.getItem('payment_token'))
							fetch(self.$store.state.api_addr + 'order/pay_order?' + sessionStorage.getItem('handle_params2'),{
								method: 'post',
								mode: 'cors',
								body: formData
							}).then((res) => {
								self.$store.dispatch('TOGGLETIP','Pay success')
							})
							break;
						case 112:
							let formData2 = new FormData()
							formData.append('token',sessionStorage.getItem('token'))
							formData.append('status',2)
							formData.append('payment_token',sessionStorage.getItem('payment_token'))
							fetch(self.$store.state.api_addr + 'order/pay_order?' + sessionStorage.getItem('handle_params2'),{
								method: 'post',
								mode: 'cors',
								body: formData2
							}).then((res) => {

							})
							break;
					}
				})
			})

			formData.append('token',sessionStorage.getItem('token'))
			formData.append('start',0)
			formData.append('limit',20)
			fetch(self.$store.state.api_addr + 'ZoneAndPlus/zone_order_list',{
				mode: 'cors',
				method: 'post',
				body: formData
			}).then((res) => {
				res.ok && res.json().then((json) => {
					self.orders = json.data
				})
			})
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.order-box{
		padding: 20px 0;
		.pay-deal-mask{
			position: fixed;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background: rgba(0,0,0,.5);
			.pay-deal{
				position: fixed;
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
			}
			.order-title-label{
				float: left;
				margin-top: 10px;
				color: $gray2;
				cursor: pointer;
				padding-left: 15px;
				font-size: 14px;
				user-select: none;
				&:hover{
					color: $primary;
				}
				&:active{
					text-decoration: underline;
				}
			}
			.order-title-label-hover{
				color: $primary;
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
		.order-table{
			width: 100%;
			padding: 0;
			margin: 0;
			font-size: 14px;
			color: $gray2;
			.order-table-header{
				width: 100%;
				height: 40px;
				line-height: 40px;
				border-top: 1px solid $gray5;
				border-bottom: 1px solid $gray5;
				margin: 20px 0;
				.order-table-header-order,.order-table-header-count,.order-table-header-total,.order-table-header-status{
					float: left;
					text-align: center;
				}
				.order-table-header-order{
					text-align: left;
					width: 35%;
					padding-left: 20px;
					box-sizing: border-box;
				}
				.order-table-header-count{
					width: 25%;
				}
				.order-table-header-total{
					width: 20%;
				}
				.order-table-header-status{
					width: 20%;
					text-align: right;
					padding-right: 20px;
					box-sizing: border-box;
				}
			}
			.order-table-item{
				position: relative;
				width: 100%;
				border: 1px solid $gray5;
				margin-bottom: 20px;
				box-sizing: border-box;
				overflow: hidden;
				.order-table-item-header{
					width: 100%;
					height: 30px;
					float: left;
					background: #f8fafb;
					margin: 0;
					padding: 0;
					border-bottom: 1px solid $gray5;
					line-height: 30px;
					color: $gray3;
					font-size: 12px;
					.order-table-item-header-order{
						padding-left: 20px;
						float: left;
					}
					.order-table-item-header-time{
						padding-right: 20px;
						float: right;
					}
				}
				.order-table-item-info{
					float: left;
					padding: 20px;
					width: 35%;
					box-sizing: border-box;
					.order-table-item-info-face{
						float: left;
						width: 100px;
						height: 75px;
						border-radius: 3px;
					}
					.order-table-item-info-content{
						margin-left: 110px;
						box-sizing: border-box;
						color: $gray2;
						&>p{
							margin: 0;
						}
						.order-table-item-info-name{
							color: $gray1;
							font-weight: bold;
							font-size: 14px;
							padding-bottom: 10px;
						}
						.order-table-item-info-des{
							font-size: 14px;
							padding-bottom: 10px;
						}
						.order-table-item-info-price{

						}
					}
				}
				.order-table-item-count{
					padding: 20px;
					box-sizing: border-box;
					width: 25%;
					float: left;
					text-align: center;
				}
				.order-table-item-total{
					padding: 20px;
					box-sizing: border-box;
					width: 20%;
					float: left;
					text-align: center;
					color: $danger;
				}
				.order-table-item-status{
					padding: 20px;
					width: 20%;
					float: left;
					text-align: right;
					box-sizing: border-box;
				}
			}
		}
	}
</style>