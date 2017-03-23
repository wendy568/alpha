<template>
	<div class="tl-box">
		<div class="tl-list">
			<ul class="tl-list-box">
				<li class="tl-item" v-for="item in video_list">
					<img class="tl-item-img" :src="item.image" alt="">
					<div class="tl-item-mask" @click="viewVideo(item.class_id)">
						<span class="tl-item-play">
							
						</span>
						<span class="tl-item-time">
							{{item.length}}
						</span>
					</div>
					<div class="video-item-info">
						<div class="video-item-top">
							<p class="video-item-title" @click="viewVideo(item.class_id)">
								{{item.name}}
							</p>
							<p class="video-item-data">
								<span class="create_time" >
									<i></i>
									{{item.create_time}}
								</span>
								<span class="video-item-like" >
									<i @click="item.like++"></i>
									{{item.like}}
								</span>
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
	</div>
</template>

<script>
	export default {
		data() {
			return {
				video_list: [
					
				],
				limit: 20,
				start: 0
			}
		},
		methods: {
			viewVideo(id) {
				const self = this
				if(sessionStorage.getItem('token')){
					let formData = new FormData()
					formData.append('class_id',id)
					formData.append('token',sessionStorage.getItem('token'))
					fetch(self.$store.state.api_addr + 'index.php/video/views_history_mark',{
						method: 'post',
						mode: 'cors',
						body: formData
					}).then((res) => {
						
					})
				}
				self.$router.push({path: '/tv_detail',query: { id: id }})
			}
		},
		mounted() {
			const self = this
			let formData = new FormData()
			formData.append('limit',self.limit)
			formData.append('start',self.start)
			fetch(self.$store.state.api_addr + 'index.php/video/list',{
				mode: 'cors',
				method: 'post',
				body: formData
			}).then((res) => {
				if(res.ok){
					res.json().then((json) => {
						self.video_list = json.data
						for(let i = 0; i < self.video_list.length; i ++) {
							self.video_list[i].image = self.$store.state.api_addr + 'upload/' + self.video_list[i].image[0] + 'm_' + self.video_list[i].image[1]
						}
					})
				}
			})
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.tl-box{
		width: $boxwidth;
		margin: 0 auto;
		.tl-list{
			padding: 20px 0;
			width: $boxwidth + 40;
			overflow: hidden;
			position: relative;
			left: -10px;
			.tl-list-box{
				overflow: hidden;
				padding: 0;
				margin: 0;
				box-sizing: border-box;
				.tl-item{
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
					.tl-item-img{
						float: left;
						width: 100%;
						height: 160px;
						background-color: #ccc;
					}
					.tl-item-mask{
						position: absolute;
						left: 0;
						top: 0;
						width: 100%;
						height: 160px;
						.tl-item-play{
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
						.tl-item-time{
							position: absolute;
							font-size: 14px;
							box-sizing: border-box;
							line-height: 24px;
							height: 24px;
							right: 25px;
							top: 15px;
							color: #fff;
							padding: 0 10px;
							border-radius: 15px;
							background-color: rgba(0,0,0,.5);
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
								.video-item-like{
									float: right;
									i{
										float: left;
										width: 24px;
										height: 24px;
										background:url(../assets/images/video_list_like.png) center center no-repeat;
										background-size:50% 50%;
										&:hover,&:focus{
											background:url(../assets/images/video_list_like_s.png) center center no-repeat;
											background-size:50% 50%;
											cursor: pointer;
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
</style>