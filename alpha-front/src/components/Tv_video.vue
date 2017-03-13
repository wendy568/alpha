<template>
	<div class="tvi-container">

		<div class="tvi-player">
			<iframe :src="detail.source" height="100%" width="100%" frameborder="0" scrolling="auto" allowfullscreen></iframe>
		</div>

		<div class="tvi-options">
			<div class="tvi-header">
				<p class="tvi-header-box">
					<span class="tvi-header-views">
						<i class="tvi-header-views-icon"></i>
						<span>{{detail.views}}</span>
					</span>
					<span class="tvi-header-comments" @click="toComment">
						<i class="tvi-header-comment-icon"></i> 
						<span>{{detail.message_count}}</span>
					</span>
					<span class="tvi-header-like" @click="like">
						<i class="tvi-header-like-icon" :class="{ 'liked': is_like }"></i> 
						<span>{{detail.like}}</span>
					</span>
					<span class="tvi-header-star" @click="follow" :class="{ 'subscribed': is_follow }">
						<i class="tvi-header-star-icon" :class="{ 'subed': is_sub }"></i>
						<span>{{detail.follow_count}}</span>
					</span>
				</p>
			</div>
			<div class="tvi-info">
				<p class="tvi-info-title">
					{{detail.name}}
				</p>
				<p class="tvi-info-text" :class="{ 'show-all': show_more }">
					{{detail.describe}}
					<span v-if="!show_more" @click="showMore" class="tvi-info-more">show more</span>
					<span v-else @click="showMore" class="tvi-info-more">show less</span>
				</p>
			</div>
		</div>

	</div>
</template>

<script>

	export default {
		data () {
			return {
				detail: {},
				is_follow: false,
				is_sub: false,
				is_like: false,
				show_more: false
			}
		},
		methods: {
			showMore () {
				const self = this
				self.show_more = !self.show_more
			},
			toComment() {
				const self = this
				document.body.scrollTop = 650
				document.getElementsByClassName('tp-edit')[0].focus()
			},
			like () {
				const self = this
				if(!sessionStorage.getItem('token')){
					self.$store.dispatch('TOGGLETIP',self.$store.state.tip.login)
					return
				}
				
				let formData = new FormData()
				formData.append('class_id',self.$route.query.id)
				formData.append('token',sessionStorage.getItem('token'))
				fetch(self.$store.state.api_addr + 'video/like',{
					mode: 'cors',
					method: 'post',
					body: formData
				}).then((res) => {
					res.ok && res.json().then((json) => {
						switch(json.archive.status){
							case 0:
								self.is_like = !self.is_like
								self.is_like === false ? self.$set( self.detail,'like',self.detail.like - 0 - 1 ) : self.$set( self.detail,'like',self.detail.like - 0 + 1 )
								break;
							case 400:
								break;
						}
					})
				})
			},
			follow () {
				const self = this
				if(!sessionStorage.getItem('token')){
					self.$store.dispatch('TOGGLETIP',self.$store.state.tip.login)
					return
				}
				let formData = new FormData()
				formData.append('class_id',self.$route.query.id)
				formData.append('token',sessionStorage.getItem('token'))
				fetch(self.$store.state.api_addr + 'video/follow_video',{
					mode: 'cors',
					method: 'post',
					body: formData
				}).then((res) => {
					res.ok && res.json().then((json) => {
						switch(json.archive.status) {
							case 0:
								self.is_follow = !self.is_follow
								self.is_follow === false ? self.$set( self.detail,'follow_count', self.detail.follow_count - 0 - 1 ) : self.$set( self.detail,'follow_count', self.detail.follow_count - 0 + 1 )
								break;
							case 400:
								break;
						}
					})
				})
			}
		},
		mounted () {
			const self = this
			let formDataDetail = new FormData()
			formDataDetail.append('class_id',self.$route.query.id)
			fetch(self.$store.state.api_addr + 'video/videos_detail',{
				method: 'post',
				mode: 'cors',
				body: formDataDetail
			}).then((res) => {
				res.ok && res.json().then((json) => {
					self.detail = json.data
					self.detail.source = '//content.jwplatform.com/players/' + json.data.source + '-T351KaXB.html'
				})
			})
//优先加载视频信息
			// self.$http.post(self.$store.state.api_addr + 'index.php/video/videos_detail',{ class_id: self.$route.query.id },{
			// 	emulateJSON: true
			// }).then((res) => {
			// 	self.title = res.data.data.name
			// 	self.nic_name = res.data.data.nic_name
			// 	self.create_time = res.data.data.create_time
			// 	self.views = res.data.data.views
			// 	self.like_count = res.data.data.like
			// 	self.follow_count = res.data.data.follow_count
			// 	self.play_id = res.data.data.id
			// 	self.message_count = res.data.data.message_count
			// 	self.from_id = res.data.data.from_id
			// 	self.describe = res.data.data.describe || "No introduction"
			// 	self.source = '//content.jwplatform.com/players/' + res.data.data.source + '-T351KaXB.html'
				
			// 	if (self.$store.state.is_online) {
			// 		self.$http.post(self.$store.state.api_addr + 'index.php/video/is_like_follow',{ class_id: self.$route.query.id,token: sessionStorage.getItem('token') },{
			// 			emulateJSON: true
			// 		}).then((res) => {
			// 			if(res.data.archive.status == 400){
			// 				return
			// 			}
			// 			res.data.data.like.is_like == "1" ? self.is_like = true : self.is_like = false
		 	// 		})

		 	// 		self.$http.post(self.$store.state.api_addr + 'index.php/personal/is_follow',{ mem_id: self.from_id,token: sessionStorage.getItem('token') },{
			// 			emulateJSON: true
			// 		}).then((res) => {
			// 			if(res.data.archive.status == 400){
			// 				return
			// 			}
			// 			res.data.data.is_follow == "yes" ? self.is_follow = true : self.is_follow = false
			// 		})
			// 	}
			// })
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.tvi-container{
		width: 100%;
		overflow: hidden;
		.tvi-player{
			width: 100%;
			height: 467px;
			background-color: $font;
		}
		.tvi-options{
			width: 100%;
			overflow: hidden;
			padding-top: 20px;
			.tvi-header{
				width: 100%;
				overflow: hidden;
				.tvi-header-box{
					width: 70%;
					padding-bottom: 7px;
					float: left;
					margin: 0;
					letter-spacing: 0;
					.tvi-header-views,.tvi-header-like,.tvi-header-comments,.tvi-header-star{
						padding-right: 15px;
						float: left;
						font-size: 15px;
						&>span{
							line-height: 16px;
						}
					}
					.tvi-header-views{
						color: $gray3;
						font-size: 15px;
						.tvi-header-views-icon{
							width: 18px;
							height: 18px;
							margin-right: 4px;
							float: left;
							vertical-align: text-top;
							background-image: url(../assets/svg/play.svg);
							background-position: center center;
							background-size: 100%;
							background-repeat: no-repeat;
						}
					}
					.tvi-header-comments{
						color: $gray3;
						cursor: pointer;
						.tvi-header-comment-icon{
							width: 18px;
							height: 18px;
							vertical-align: text-top;
							display: inline-block;
							background-image: url(../assets/svg/comment.svg);
							background-position: center center;
							background-size: 100%;
							background-repeat: no-repeat;
						}
						&:hover{
							color: #ccc;
						}
					}
					.tvi-header-like{
						color: $gray3;
						cursor: pointer;
						.tvi-header-like-icon{
							width: 18px;
							height: 18px;
							vertical-align: text-top;
							display: inline-block;
							background-image: url(../assets/svg/like.svg);
							background-position: center center;
							background-size: 100%;
							background-repeat: no-repeat;
						}
						.liked{
							color: $danger;
						}
					}
					.tvi-header-star{
						color: $gray3;
						cursor: pointer;
						.tvi-header-star-icon{
							width: 18px;
							height: 18px;
							vertical-align: text-top;
							display: inline-block;
							background-image: url(../assets/svg/star.svg);
							background-position: center center;
							background-size: 100%;
							background-repeat: no-repeat;
						}
						.liked{
							color: $danger;
						}
					}
				}
				.tvi-header-sub{
					width: 30%;
					float: right;
					line-height: 58px;
					.tvi-header-author{
						color: $gray1;
						font-size: 16px;
						float: right;
						padding: 0 10px; 
					}
					.tvi-header-sub-btn{
						font-size: 13px;
						color: $font;
						border-radius: 2px;
						float: right;
						text-decoration: none;
						.tvi-header-sub-name{
							background-color: #f25b42;
							color: #fff;
							text-align: center;
							padding: 6px 10px;
							border-radius: 3px;
							cursor: pointer;
						}
						.subscribed{
							background-color: #999;
						}
						.tvi-header-sub-count{
							text-align: center;
							padding: 5px 10px;
							border: 1px solid #ccc;
							border-left: none;
							border-top-right-radius: 3px;
							border-bottom-right-radius: 3px;
							color: $gray1;
						}
					}
				}
			}
			.tvi-info{
				float: left;
				width: 100%;
				overflow: hidden;
				.tvi-info-title{
					padding-top: 5px;
					width: 100%;
					color: $gray1;
					font-size: 20px;
					margin: 0;
					line-height: 2rem;
				}
				.tvi-info-text{
					width: 100%;
					color: $font;
					font-size: 13px;
					line-height: 1.5;
					margin: 0;
					padding: 10px 0;
					max-height: 30px;
					overflow: hidden;
					.tvi-info-more{
						display: block;
						color: $danger;
						text-align: center;
						font-size: 16px;
						position: relative;
						text-decoration: none;
						cursor: pointer;
						user-select: none;
						&:hover{
							color: #169e83;
							border-color: #169e83;
						}
					}
				}
				.show-all{	
					max-height: 500px;
				}
			}
		}
	}
</style>