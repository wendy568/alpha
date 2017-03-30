<template>
    <div class="fav-box">
        <div class="fav-header">
            <span class="fav-title">
				所有视频
			</span>
        </div>
        <div class="fav-list">
            <ul class="fav-list-box">
				<li class="fav-item" v-for="item in video_list">
					<img class="fav-item-img" :src="item.image" alt="">
					<div class="fav-item-mask">
						<span class="fav-item-play" @click="viewVideo(item.class_id)">
							
						</span>
						<span class="fav-item-time">
							{{item.length}}
						</span>
					</div>
					<div class="fav-item-info">
						<div class="fav-item-top">
							<p class="fav-item-tifave">
								{{item.name}}
							</p>
						</div>
						<div class="fav-item-bottom">
							<span class="fav-item-create">
								{{item.create_time}}
							</span>
							<span @click="delete_fa" class="fav-item-mark"></span>
						</div>
					</div>
				</li>
			</ul>
        </div>
		<!-- alert -->
        <div class="alert" v-if="confirm">
        	<div class="alert-box">
        		<img src="../assets/images/alert_delete_icon.png" alt="" class="title-img">
        		<p class="message">确认取消收藏吗？</p>
        		<p class="btn">
        			<button class="btn-default-out" @click="confirm_del">确认</button>
        			<button class="btn-default-out"  @click="confirm=false">关闭</button>
        		</p>
        	</div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                video_list: [],
				delete_ids: [],
				confirm:false
            }
        },
		mounted() {
			const self = this
			fetch(self.$store.state.api_addr + 'video/follow_videos_list',{
			 	method: 'post',
			 	headers: {
			 		'Content-Type': 'application/x-www-form-urlencoded'
			 	},
			 	body: 'date_limit' + 1 + '&token=' + sessionStorage.getItem('token')
			}).then((res) => {
				res.ok && res.json().then((json) => {
						self.video_list = json.data
						for(let i = 0;i < self.video_list.length;i ++){
							if(self.video_list[i].image !== null || self.video_list[i].image !== "" || self.video_list[i].image !== undefined){
								self.video_list[i].image = self.$store.state.api_addr + 'upload/' + self.video_list[i].image[0] + 'm_' + self.video_list[i].image[1]	
							}else{
								self.video_list[i].image = 'http://content.jwplatform.com/thumbs/' + self.video_list[i].source + '-320.jpg'	
							}
						}				
					})
				}
			)
			fetch(self.$store.state.api_addr + 'video/follow_videos_list',{
			 	method: 'post',
			 	headers: {
			 		'Content-Type': 'application/x-www-form-urlencoded'
			 	},
			 	body: 'date_limit' + 2 + '&token=' + sessionStorage.getItem('token')
			}).then((res) => {
				res.ok && res.json().then((json) => {
						self.video_list = json.data
						for(let i = 0;i < self.video_list.length;i ++){
							if(self.video_list[i].image !== null || self.video_list[i].image !== "" || self.video_list[i].image !== undefined){
								self.video_list[i].image = self.$store.state.api_addr + 'upload/' + self.video_list[i].image[0] + 'm_' + self.video_list[i].image[1]	
							}else{
								self.video_list[i].image = 'http://content.jwplatform.com/thumbs/' + self.video_list[i].source + '-320.jpg'	
							}
						}				
					})
				}
			)
			fetch(self.$store.state.api_addr + 'video/follow_videos_list',{
			 	method: 'post',
			 	headers: {
			 		'Content-Type': 'application/x-www-form-urlencoded'
			 	},
			 	body: 'date_limit' + 3 + '&token=' + sessionStorage.getItem('token')
			}).then((res) => {
				res.ok && res.json().then((json) => {
						self.video_list = json.data
						for(let i = 0;i < self.video_list.length;i ++){
							if(self.video_list[i].image !== null || self.video_list[i].image !== "" || self.video_list[i].image !== undefined){
								self.video_list[i].image = self.$store.state.api_addr + 'upload/' + self.video_list[i].image[0] + 'm_' + self.video_list[i].image[1]	
							}else{
								self.video_list[i].image = 'http://content.jwplatform.com/thumbs/' + self.video_list[i].source + '-320.jpg'	
							}
						}				
					})
				}
			)
			fetch(self.$store.state.api_addr + 'video/follow_videos_list',{
			 	method: 'post',
			 	headers: {
			 		'Content-Type': 'application/x-www-form-urlencoded'
			 	},
			 	body: 'date_limit' + 4 + '&token=' + sessionStorage.getItem('token')
			}).then((res) => {
				res.ok && res.json().then((json) => {
						self.video_list = json.data
						for(let i = 0;i < self.video_list.length;i ++){
							if(self.video_list[i].image !== null || self.video_list[i].image !== "" || self.video_list[i].image !== undefined){
								self.video_list[i].image = self.$store.state.api_addr + 'upload/' + self.video_list[i].image[0] + 'm_' + self.video_list[i].image[1]	
							}else{
								self.video_list[i].image = 'http://content.jwplatform.com/thumbs/' + self.video_list[i].source + '-320.jpg'	
							}
						}				
					})
				}
			)
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
			},
			delete_fa() {
				const self = this
				self.confirm=!self.confirm

			},
			confirm_del(){
				
			}
		}
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .fav-box{
        width: $boxwidth;
        position: relative;
        .fav-header{
            width: 100%;
			overflow: hidden;
            padding: 15px 0;
			.fav-title{
				float: left;
				margin-top: 10px;
				border-left: 2px solid $primary;
				color: $gray2;
				font-size: 14px;
				padding-left: 5px;
			}
            .fav-delete{
                color: $gray3;
                text-align: center;
                outline: none;
                border: 1px solid $gray5;
                background: transparent;
                border-radius: 2px;
                float: right;
                box-sizing: border-box;
                height: 32px;
                margin-right: 15px;
                padding: 0 15px;
				cursor: pointer;
				&:hover{
					background: $primary;
					color: #fff;
					border: none;
					.fav-delete-icon{
						background-image: url(../assets/images/fav_delete_hover.png);
					}
				}
                .fav-delete-icon{
					background-image: url(../assets/images/fav_delete.png);
					background-position: center center;
					background-size: 100% 100%;
					background-repeat: no-repeat;
					width: 15px;
					height: 15px;
					float: left;
					margin-right: 5px;
                }
                .fav-delete-text{

                }
            }
			.fav-search{
				float: right;
				width: 200px;
				height: 32px;
				border: 1px solid $gray5;
				color: $gray3;
				padding: 0 15px;
                box-sizing: border-box;
				line-height: 32px;
				border-radius: 3px;
				outline: none;
			}
        }
        .fav-list{
            width: $boxwidth + 40;
            overflow: hidden;
            position: relative;
            left: -10px;
            .fav-list-box{
				padding: 0;
                margin: 0;
				box-sizing: border-box;
				.fav-item{
					position: relative;
					width: $boxwidth/4 - 15;
					margin-left: 10px;
					margin-right: 10px;
					margin-bottom: 20px;
                    cursor: pointer;
					float: left;
					box-sizing: border-box;
                    transition: all .35s;
                    &:hover{
                        box-shadow: 0 0 18px rgba(0,0,0,.18);
                    }
					.fav-item-img{
						float: left;
						width: 100%;
						height: 160px;
						background-color: #ccc;
					}
					.fav-item-mask{
						position: absolute;
						left: 0;
						top: 0;
						width: 100%;
						height: 160px;
						.fav-item-play{
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
						.fav-item-time{
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
					.fav-item-info{
						width: 100%;
						float: left;
						border: 1px solid $gray5;
						box-sizing: border-box;
						.fav-item-top{
							box-sizing: border-box;
							padding: 20px 10px 0px 10px;
							.fav-item-tifave{
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
							.fav-item-data{
								color: $gray3;
								font-size: 12px;
								overflow: hidden;
								.fav-item-author{
									float: left;
								}
								.fav-item-comment{
									float: left;
								}
								.fav-item-like{
									float: right;
								}
							}
						}
						.fav-item-bottom{
							border-top: 1px solid $gray5;
							height: 30px;
							width: 100%;
							line-height: 30px;
							padding: 0 10px;
							color: $gray3;
							box-sizing: border-box;
							font-size: 12px;
							.fav-item-create{
								float: left;
							}
							.fav-item-mark{
								float: right;
								width: 16px;
								height: 16px;
								position: relative;
								top: 7px;
								background: url(../assets/images/checkbox.png) no-repeat;
								background-size: 100%;
								border:1px solid $primary;
							}
						}
					}
				}
			}
        }
        .alert{
        	position: fixed;
            left: 0;
            top: 0;
        	width: 100%;
        	height: 100%;
        	background: rgba(0,0,0,.7);
        	.alert-box{
        		position: absolute;
        		width: 400px;
        		height: 230px;
        		background-color: #fff;
        		left: 50%;
        		top:30%;
        		margin-left: -200px;
        		.title-img{
        			width: 50px;
        			height: 50px;
        			margin: 30px auto;
        			display: block;
        		}
        		.message{
    				text-align: center;
    				color: $gray1;
    				font-size: 16px;
    			}
    			.btn{
    				padding-left: 100px;
    				font-size: 14px;
    				color: $gray3;
    				margin:10px 0;
    				.btn-default-out{
    					&:hover{
    						color:#fff;
    						background-color:$primary; 
    						border:1px solid $primary;
    					}
    				}
    			}
        	}
        }
    }
</style>