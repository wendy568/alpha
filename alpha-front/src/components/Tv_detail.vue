<template>
	<div class="tp-container">

		<div class="tp-left">
			<div class="tp-video">
				<tv_video></tv_video>
			</div>
			<div class="tp-publish">
				<img class="tp-publish-img" :src="$store.state.user_face" alt="">
				<div class="tp-publish-box">
					<textarea class="tp-edit" v-model="reply_message" cols="30" rows="10" placeholder="Add a public comment…"></textarea>
					<p class="tp-publish-btns">
						<span class="tp-publish-comment btn-primary" @click="replyHigh">Publish</span>
					</p>	
				</div>
			</div>
			<div class="tp-comments">
				<player_comment></player_comment>
			</div>	
		</div>

		<div class="tp-right">
			<ul class="tp-suggest-list">
				<li class="tp-suggest-item" v-for="item in recommend_list">
					<div>
						<img class="tp-suggest-img" :src="item.image" />
					</div>
					<div class="tp-suggest-mask" @click="viewVideo(item.class_id)">
						<span class="tp-item-play">
							
						</span>
						<span class="tp-item-time">
							{{item.length}}
						</span>
					</div>
					<div class="tp-suggest-box">
						<router-link class="tp-suggest-title" @click="view(item.class_id)" :to="{ path: '/tv_detail',query: { id: item.class_id } }">{{item.name}}</router-link>
						<div class="tp-suggest-options">
							<div class="tp-suggest-views">
								<i class="tp-suggest-views-icon"></i>
								<span>{{item.views}}</span>	
							</div>
							<div class="tp-suggest-other">
								<i class="tp-suggest-comment-icon"></i>
								<span class="tp-suggest-comment-text">{{item.comment_count}}</span>	

								<i class="tp-suggest-like-icon"></i>
								<span class="tp-suggest-like-text">{{item.like}}</span>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>

	</div>
</template>

<script>
	import $ from 'jquery'
	export default {
		data () {
			return {
				face: '../assets/images/portrait.jpg',
				recommend_list: [
					// { image: '../assets/images/act1.jpg',views: 4561,id: 5,title: 'Google Photos now creates share gifs from your videos',like_count: 251,comment_count: 851,length: '34:00' },
					// { image: '../assets/images/act2.jpg',views: 1151,id: 5,title: 'Google Photos now creates share gifs from your videos',like_count: 251,comment_count: 851,length: '34:00' },
					// { image: '../assets/images/act3.jpg',views: 8416,id: 5,title: 'Google Photos now creates share gifs from your videos',like_count: 251,comment_count: 851,length: '34:00' }
				],
				reply_message: ''
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
				location.reload()
			},
			replyHigh () {
				const self = this
				if(!sessionStorage.getItem('token')){
					self.$store.dispatch('TOGGLELOGIN','on')
					return 
				}
				if(self.reply_message == "" || self.reply_message == null || self.reply_message == undefined ){
					self.$store.dispatch('TOGGLETIP','Comment cannot be empty')
					return
				}
				let formData = new FormData()
				formData.append('class_id',self.$route.query.id)
				formData.append('token',sessionStorage.getItem('token'))
				formData.append('mess_id',0)
				formData.append('content',self.reply_message)
				fetch(self.$store.state.api_addr + 'video/reply_message_me',{
					method: 'post',
					mode: 'cors',
					body: formData
				}).then((res) => {
					res.ok && res.json().then((json) => {
						switch(json.archive.status) {
							case 0:
								let li = $('<li class="tpc-item">' + 
												'<div class="tpc-item-left">' + 
													'<img class="tpc-item-img" src="' + self.$store.state.user_face + '">' + 
												'</div>' + 
												'<div class="tpc-item-right">' +
													'<p class="tpc-item-header">' + 
														'<span class="tpc-item-name">' + self.$store.state.first_name + '</span>' +	
													'</p>' +
													'<p class="tpc-item-content">' + self.reply_message + '</p>' + 
												'</div>' +
											'</li>')
								if(self.show_comment == true){
									self.show_comment = false
								}
								$('.tpc-list').prepend(li)
								self.reply_message = ''
								break;
							case 400:
								break;
						}
					})
				})
			}
		},
		components: {
			'tv_video'  (resolve) {
				require(['./tv_video'], resolve)
			},
			'player_comment' (resolve) {
				require(['./player_comment'], resolve)
				// this.show_video = true
			}
		},
		mounted () {
			const self = this
			fetch(self.$store.state.api_addr + 'video/list',{
			 	method: 'post',
			 	headers: {
			 		'Content-Type': 'application/x-www-form-urlencoded'
			 	},
			 	body: 'limit=' + 3 + '&start=' + 0 
			}).then((res) => {
				if(res.ok){
					res.json().then((json) => {
						self.recommend_list = json.data
						for(let i = 0;i < self.recommend_list.length;i ++){
							if(self.recommend_list[i].image !== null || self.recommend_list[i].image !== "" || self.recommend_list[i].image !== undefined){
								self.recommend_list[i].image = self.$store.state.api_addr + 'upload/' + self.recommend_list[i].image[0] + 'm_' + self.recommend_list[i].image[1]	
							}else{
								self.recommend_list[i].image = 'http://content.jwplatform.com/thumbs/' + self.recommend_list[i].source + '-320.jpg'	
							}
						}				
					})
				}
				
			})
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.tp-container{
		width: 1140px;
		margin: 0 auto;
		overflow: hidden;
		.tp-left{
			width: 830px;
			overflow: hidden;
			background-color: #fff;
			box-sizing: border-box;
			float: left;
			.tp-video{
				padding: 20px 0;
			}
			.tp-publish{
				overflow: hidden;
				position: relative;
				.tp-publish-img{
					width: 60px;
					height: 60px;
					border-radius: 50%;
					float: left;
					position: absolute;
					left: 0;
					top: 0;
				}
				.tp-publish-box{
					width: 100%;
					position: relative;
					box-sizing: border-box;
					padding-left: 70px;
					.tp-edit{
						width: 100%;
						height: 70px;
						background-color: #f8f8f8;
						border: 1px solid #f3f3f5;
						padding: 10px 15px;
						transition: all .2s;
						outline: none;
						box-sizing: border-box;
						border-radius: 2px;
						&:hover{
							background-color: rgba(255,255,255,1);
						}
					}
					.tp-publish-btns{
						overflow: hidden;
						.tp-publish-comment{
							float: right;
							position: relative;
						}
					}	
				}
			}
		}
		.tp-right{
			width: 270px;
			float: left;
			overflow: hidden;
			box-sizing: border-box;
			background-color: #fff;
			margin-left: 40px;
			margin-top: 20px;
			.tp-suggest-list{
				width: 100%;
				padding: 0;
				margin: 0;
				.tp-suggest-item{
					width: 100%;
					padding-bottom: 18px;
					box-sizing: border-box;
					float: left;
					overflow: hidden;
					position: relative;
					.tp-suggest-img{
						float: left;
						width: 100%;
						height: 160px;
						cursor: pointer;
					}
					.tp-suggest-mask{
						position: absolute;
						left: 0;
						top: 0;
						width: 100%;
						height: 160px;
						background-color: rgba(0,0,0,.18);
						.tp-item-play{
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
						.tp-item-time{
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
					.tp-suggest-box{
						float: left;
						width: 100%;
						padding: 5px 0;
						box-sizing: border-box;
						.tp-suggest-title{
							text-decoration: none;
							color: #333;
							font-size: 14px;
							max-height: 3.2rem;
							overflow: hidden;
							line-height: 18px;
							margin: 0;
						}
						.tp-suggest-options{
							color: $font;
							font-size: 1rem;
							margin: 0;
							padding: 14px 0;
							overflow: hidden;
							border-bottom: 1px solid #f3f3f5;
							.tp-suggest-views{
								float: left;
								.tp-suggest-views-icon{
									display: inline-block;
									background-image: url(../assets/svg/play.svg);
									background-repeat: no-repeat;
									background-position: center center;
									background-size: 100%;
									width: 18px;
									height: 18px;
								}
								&>span{
									display: inline-block;
									font-size: 12px;
									vertical-align: text-top;
									line-height: 16px;
								}	
							}
							.tp-suggest-other{
								float: right;
								.tp-suggest-comment-icon{
									display: inline-block;
									background-image: url(../assets/svg/comment.svg);
									background-repeat: no-repeat;
									background-position: center center;
									background-size: 100%;
									width: 18px;
									height: 18px;
								}
								.tp-suggest-comment-text{
									display: inline-block;
									font-size: 12px;
									vertical-align: text-top;
									line-height: 16px;
								}
								.tp-suggest-like-icon{
									display: inline-block;
									background-image: url(../assets/svg/like.svg);
									background-repeat: no-repeat;
									background-position: center center;
									background-size: 100%;
									width: 18px;
									height: 18px;	
								}
								.tp-suggest-like-text{
									display: inline-block;
									font-size: 12px;
									vertical-align: text-top;
									line-height: 16px;
								}
							}
						}
					}
				}
				.tp-suggest-item:last-child{
					padding-bottom: 0;
				}
			}
		}
	}
</style>