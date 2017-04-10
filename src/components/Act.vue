<template>
	<div class="act-mask">
		<div class="act-box">
			
			<div class="act-header">
				<div class="act-header-mask">
					<div class="act-header-title">
						{{header.title}}
					</div>
					<span class="act-header-status">
						{{header.status}}
					</span>
				</div>
			</div>

			<ul class="act-list">
				<li class="act-item" v-for="item in list">
					<div class="act-item-date">
						<div class="act-item-date-box">
							<p class="act-item-date-day">
								{{item.day}}
							</p>
							<p class="act-item-date-month">
								{{item.month}}月
							</p>
						</div>
					</div>

					<div class="act-item-img">
						<div class="act-item-img-mask">
							<img class="act-item-image" :src="item.image" alt="">
							<span v-if="item.status" class="act-item-stauts">报名中</span>
							<span v-else class="act-item-stauts">进行中</span>
						</div>
					</div>

					<div class="act-item-info">
						<h3 class="act-item-info-title" @click="pay(item.id,item.price)">
							{{item.name}}
						</h3>
						<p class="act-item-info-des">
							Description：{{item.describe}}
						</p>
						<p class="act-item-info-length">
							{{item.start}} - {{item.end}}
						</p>
						<p class="act-item-info-place">
							{{item.location}}
						</p>
						<button class="btn-primary" @click="pay(item.id,item.price)">
							Apply
						</button>
					</div>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				header: {
					title: '炒鸡路演，攀谈会：风口上的网红经济',
					status: '进行中'
				},
				list: [
				],
				start: 0,
				limit: 10
			}
		},
		mounted() {
			const self = this
			let formData = new FormData()
			formData.append('start',self.start)
			formData.append('limit',self.limit)
			fetch(self.$store.state.api_addr + 'activity/Activity_list',{
				mode: 'cors',
				method: 'post',
				body: formData
			}).then((res) => {
				if(res.ok){
					res.json().then((json) => {
						let key = 0
						if(json.data !== []){
							for(let y in json.data){
								for(let m in json.data[y]){
									for(let d in json.data[y][m]){
										for(let o in json.data[y][m][d]){
											json.data[y][m][d][o].year = y.replace('_','')
											json.data[y][m][d][o].month = m.replace('_','')
											json.data[y][m][d][o].day = d.replace('_','')
											json.data[y][m][d][o].image && ( json.data[y][m][d][o].image = self.$store.state.api_addr + 'upload/' + json.data[y][m][d][o].image[0] + 'm_' + json.data[y][m][d][o].image[1] )
											self.list.unshift(json.data[y][m][d][o])
											key ++
										}
									}
								}
							}
						}
					})
				}
			})
		},
		methods: {
			pay(id,price) {
				const self = this
				self.$store.dispatch('CHANGEPAYINFO',price)
				self.$store.dispatch('CHANGEACTID',id)
				self.$router.push({path: '/act_detail',query: { id: id, price : price }})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import '../css/alpha.scss';
	.act-mask{
		width: 100%;
		overflow: hidden;
		.act-box{
			width: 1140px;
			overflow: hidden;
			margin: 0 auto;
			padding-top: 20px;
			.act-header{
				width: 100%;
				height: 230px;
				float: left;
				background-image: url(../assets/images/act_banner.jpg);
				background-size: 100%;
				background-position: center top;
				background-repeat: no-repeat;
				color: #fff;
				.act-header-mask{
					width: 100%;
					height: 100%;
					background-color: rgba(0,0,0,.18);
					padding: 20px;
					box-sizing: border-box;
					position: relative;
					.act-header-title{
						position: absolute;
						bottom: 20px;
						left: 20px;
						font-weight: 600;
					}
					.act-header-status{
						position: absolute;
						left: 15px;
						top: 15px;
						background: $success;
						color: #fff;
						height: 30px;
						line-height: 30px;
						width: 80px;
						text-align: center;
						border-radius: 3px;
						font-size: 14px;
					}
				}
			}
			.act-list{
				width: 100%;
				overflow: hidden;
				float: left;
				padding: 0;
				padding-top: 30px;
				box-sizing: border-box;
				.act-item{
					width: 100%;
					height: 210px;
					overflow: hidden;
					margin-bottom: 35px;
					.act-item-date{
						width: 80px;
						height: 80px;
						float: left;
						border: 1px solid #e6edf6;
						border-radius: 3px;
						.act-item-date-box{
							padding: 15px 20px;
							text-align: center;
							color: #838b9b;
							.act-item-date-day{
								font-weight: 600;
								font-size: 20px;
								margin: 0;
								padding: 0;
								padding-bottom: 11px;
							}

							.act-item-date-month{
								margin: 0;
								padding: 0;
								font-weight: 600;
								font-size: 12px;
								color: $gray3;
							}
						}
					}
					.act-item-img{
						float: left;
						width: 350px;
						height: 100%;
						padding-left: 30px;
						.act-item-img-mask{
							position: relative;
							width: 100%;
							height: 100%;
							border-radius: 3px;
							.act-item-image{
								width: 100%;
								height: 100%;
							}
							.act-item-stauts{
								position: absolute;
								left: 15px;
								top: 15px;
								background: $success;
								color: #fff;
								height: 30px;
								line-height: 30px;
								width: 80px;
								text-align: center;
								border-radius: 3px;
								font-size: 14px;
							}
						}
					}
					.act-item-info{
						padding-left: 25px;
						float: left;
						color: $font;
						position: relative;
						font-size: 12px;
						height: 100%;
						.act-item-info-title{
							padding: 0;
							margin: 0;
							font-size: 16px;
							color: #343c4d;;
							padding-bottom: 20px;
							cursor: pointer;
							&:hover{
								color:$primary;
								transition:all .3s;
							}
						}
						.act-item-info-des{
							margin: 0;
							padding-bottom: 15px;
						}
						.act-item-info-length{
							margin: 0;
							padding-bottom: 15px;
						}
						.act-item-info-place{
							margin: 0;
							padding-bottom: 15px;
						}
					}
				}
			}
		}
	}
</style>