<template>
	<div class="tp-comment" id="comments">
		<div class="tp-comment-box">
			<ul class="tpc-list">
				<div class="no-comment" v-if="show_comment">
					There is no comment,the first sofa for you!
				</div>
				<li class="tpc-item" v-for="i in comment" :id="'tpci-' + i.id">
					<div class="tpc-item-left">
						<img class="tpc-item-img" :src="i.from_face">
					</div>
					<div class="tpc-item-right">
						<p class="tpc-item-header">
							<span class="tpc-item-name">{{i.from_name}}</span>
							<span class="tpc-item-time">{{i.create_time}}</span>
						</p>
						<p class="tpc-item-content">{{i.content}}</p>
					</div>
				</li>
				<div class="tpc-more" @click="viewMore">show more</div>
			</ul>	
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				comment: [
					// { id: 45, from_face: '../assets/images/portrait.jpg', from_name: 'Sinari', create_time: "2016-8-30", content: "Just keep your mind open and suck in the experience and if it hurts,it's probably worth it." ,from_id: 2 },
					// { id: 45, from_face: '../assets/images/portrait.jpg', from_name: 'Sinari', create_time: "2016-10-31", content: "Just keep your mind open and suck in the experience and if it hurts,it's probably worth it." ,from_id: 2 }
				],
				reply_message_child: "",
				reply_message: "",
				level1: false,
				show_comment: false,
				limit_comment: 10,
				start_comment: 0,
				option: {

				}
			}
		},
		mounted() {
			const self = this
//第一步加载一级评论
			let formData = new FormData()
			formData.append('class_id',self.$route.query.id)
			formData.append('start',self.start_comment)
			formData.append('limit',self.limit_comment)
			fetch(self.$store.state.api_addr + 'video/message_list',{
				method: 'post',
				mode: 'cors',
				body: formData
			}).then((res) => {
				res.ok && res.json().then((json) => {
						self.comment = json.data
						if(json.data.length == 0){
							self.show_comment = true
						}else{
							for(let s = 0; s < self.comment.length; s ++){
								let f
								if(json.data[s].from_face !== null){
									f = json.data[s].from_face
									self.comment[s].from_face = self.$store.state.api_addr + 'upload/' + f[0] + 'm_' + f[1]
								}else{
									self.comment[s].from_face = '../assets/images/portrait.jpg'
								}
								if( s == self.comment.length - 1){
									self.level1 = true
								}
							}	
						}		
					})
				}
			)
			
//第二步加载二级评论
			// let time = window.setInterval(function(){
			// 	if(self.level1 == true){
			// 		for(let i = 0; i < self.comment.length; i ++){
			// 			self.$http.post(self.serverAddr + 'index.php/video/reply_message_list',{ class_id: self.$route.query.class_id,mess_id: self.comment[i].id },{
			// 				emulateJSON: true
			// 			}).then(function(res){
			// 				let ul = $('<ul class="tpc-item-list"></ul>')
			// 				if(res.data.data == "[]" || res.data.data == []){
			// 					return
			// 				}else{
			// 					for(let j = 0; j < res.data.data.length; j ++){
			// 						let d = res.data.data[j]
			// 						let f
			// 						if(d.from_face !== null || d.from_face !== undefined){
			// 							f = d.from_face
			// 							d.from_face = self.serverAddr + 'upload/' + f[0] + 'm_' + f[1]
			// 						}else{
			// 							d.from_face = '../../dist/images/defaultface.png'
			// 						}
									
			// 						let li = $(
			// 						'<li class="tpc-item-list-item">' +
			// 							'<div class="tpc-item-list-item-left">' +
			// 								'<img class="tpc-item-list-item-img" src="' + d.from_face + '" alt="">' +
			// 							'</div>' +
			// 							'<div class="tpc-item-list-item-right">' +
			// 								'<p class="tpc-item-list-item-header">' +
			// 									'<span class="tpc-item-list-item-name">' + d.from_name + '</span>' +
			// 									'<span class="tpc-item-list-item-time">' + d.create_time + '</span>' +
			// 								'</p>' +
			// 								'<p class="tpc-item-list-item-content">' + d.content + '</p>' +
			// 							'</div>' +
			// 						'</li>')
			// 						ul.append(li)	
			// 					}
			// 				}
			// 				$('#tpci-' + self.comment[i].id + ' .tpc-item-footer').before(ul)
			// 			})
			// 		}
			// 		clearInterval(time)
			// 	}
			// },500)
		},
		methods: {
			toggleReply (id) {
				const self = this
				if(!sessionStorage.getItem('token')){
					
					return 
				}
				$('.tpc-comment-box').not('#tpccb-' + id).fadeOut(350)
				$('#tpccb-' + id).fadeToggle(350)	
			},	
			reply (from_id,mess_id) {
				const self = this
				if(!sessionStorage.getItem('token')){
					
					return 
				}
				if(self.reply_message_child == "" || self.reply_message_child == null || self.reply_message_child == undefined ){
					return
				}
				fetch(self.$store.state.api_addr + 'video/reply_message',{ class_id: self.$route.query.class_id,mess_id: mess_id,token: sessionStorage.getItem('token'),from_id: from_id,content: self.reply_message_child},{
					emulateJSON: true
				}).then((res) => {
					self.reply_message_child = ''
					window.location.reload()
				})
			},
			viewMore () {
				let self = this
				self.$http.post(self.$store.state.api_addr + 'video/message_list',{ class_id: self.$route.query.id,limit: self.limit_comment + 4 },{
					emulateJSON: true
				}).then((res) => {
					let olength = self.comment.length
					self.limit_comment += 4
					self.comment = res.data.data
					if(self.comment.length == olength){
						
					}
					for(let s = 0; s < self.comment.length; s ++){
						var f
						if(res.data.data[s].from_face !== null){
							f = res.data.data[s].from_face
							self.comment[s].from_face = self.serverAddr + 'upload/' + f[0] + 'm_' + f[1]
						}else{
							self.comment[s].from_face = '../assets/images/portrait.jpg'
						}
						
						if( s == self.comment.length - 1){
							self.level1 = true
						}
					}
				})
				let time = window.setInterval(() => {
					if(self.level1 == true){
						for(let i = 0; i < self.comment.length; i ++){
							self.$http.post(self.$store.state.api_addr + 'video/reply_message_list',{ class_id: self.$route.query.class_id,mess_id: self.comment[i].id },{
								emulateJSON: true
							}).then((res) => {
								let ul = $('<ul class="tpc-item-list"></ul>')
								if(res.data.data == "[]" || res.data.data == []){
									return
								}else{
									for(let j = 0; j < res.data.data.length; j ++){
										let d = res.data.data[j]
										let f
										if(d.from_face !== null || d.from_face !== undefined){
											f = d.from_face
											d.from_face = self.$store.state.api_addr + 'upload/' + f[0] + 'm_' + f[1]
										}else{
											d.from_face = '../assets/images/portrait.jpg'
										}
										
										let li = $(
										'<li class="tpc-item-list-item">' +
											'<div class="tpc-item-list-item-left">' +
												'<img class="tpc-item-list-item-img" src="' + d.from_face + '" alt="">' +
											'</div>' +
											'<div class="tpc-item-list-item-right">' +
												'<p class="tpc-item-list-item-header">' +
													'<span class="tpc-item-list-item-name">' + d.from_name + '</span>' +
												'</p>' +
												'<p class="tpc-item-list-item-content">' + d.content + '</p>' +
											'</div>' +
										'</li>')
										ul.append(li)	
									}
								}
								$('#tpci-' + self.comment[i].id + ' .tpc-item-footer').before(ul)
							})
						}
						clearInterval(time)
					}
				},500)
			},
			notice () {
				$('.notice-container').animate({
					'display': 'block',
					'opacity': 1
				},500,function(){
					$('.notice-container').animate({
						'opacity': 0
					},500,function(){
						$('.notice-container').animate({
							'opacity': 1
						},500,function(){
							$('.notice-container').animate({
								'display': 'none',
								'opacity': 0
							},500)
						})	
					})
				})
			}
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.tp-comment{
		width: 100%;
		padding-right: 60px;
		.tp-comment-box{
			width: 100%;
			height: 100%;
			background-color: #fff;
			.tpc-list{
				text-align: left;
				overflow: hidden;
				width: 100%;
				padding: 15px 0;
				border-top: 1px solid $gray5;
				.no-comment{
					text-align: center;
					width: 100%;
					line-height: 50px;
					font-family: cursive;
					font-size: 1.66666667rem;
					color: #9e9e9e;
					padding-bottom: 20px;
					letter-spacing: .8px;
				}
				.tpc-item{
					width: 100%;
					overflow: hidden;
					padding: 20px 0;
					border-bottom: 1px solid #f3f3f5;
					.tpc-item-left{
						width: 70px;
						float: left;
						height: 100%;
						.tpc-item-img{
							width: 40px;
							height: 40px;
							border-radius: 50%;
							box-sizing: border-box;
						}
					}	
					.tpc-item-right{
						width: 100%;
						height: 100%;
						font-size: 14px;
						.tpc-item-header{
							width: 100%;
							padding-top: 5px;
							margin: 0;
							.tpc-item-name{
								padding-right: 15px;
								color: $primary;
							}
							.tpc-item-time{
								color: #bbb;
							}
						}
						.tpc-item-content{
							width: 100%;
							margin: 0;
							color: $font;
							padding-top: 5px;
							display: list-item;
						}
						.tpc-item-footer{
							bottom: 0;
							width: 100%;
							overflow: hidden;
							a{
								color: #bbb;
								float: right;
								line-height: 30px;
								cursor: pointer;
								padding-right: 5px;
								&:hover{
									color: #999;
								}
							}
						}
						.tpc-item-list{
							width: 95%;
							overflow: hidden;
							margin-top: 10px;
							.tpc-item-list-item{
								width: 100%;
								overflow: hidden;
								padding: 15px;
								padding-left: 0;
								min-height: 80px;
								.tpc-item-list-item-left{
									width: 50px;
									float: left;
									height: 50px;
									.tpc-item-list-item-img{
										width: 30px;
										height: 30px;
										border-radius: 50%;
									}
								}
								.tpc-item-list-item-right{
									width: e("calc(100% - 50px)");
									float: right;
									height: 100%;
									.tpc-item-list-item-header{
										width: 100%;
										.tpc-item-list-item-name{
											padding-right: 20px;
										}
									}
									.tpc-item-list-item-content{
										width: 100%;
										color: #6e4e4e;
									}
								}
							}
						}
						.tpc-comment-box{
							width: 100%;
							padding-bottom: 10px;
							display: none;
							position: relative;
							input{
								width: 100%;
								padding: 10px;
								padding-right: 100px;
								outline: none;
								border: 1px solid #ccc;
								border-radius: 3px;
							}
							.tpc-comment-btn{
								position: absolute;
								right: 9px;
								bottom: 17px;
								cursor: pointer;
								padding: 2px 5px;
								background-color: rgba(0,0,0,.2);
								color: #fff;
								border-radius: 3px;
								transition: all .35s;
								&:hover{
									background-color: rgba(0,0,0,.15);
								}
								&:active{
									background-color: rgba(0,0,0,.1);
								}
							}
						}
					}
				}
				.tpc-more{
					margin-top: 20px;
					text-align: center;
					background: #f1f1f1;
					padding: 8px 0;
					font-size: 14px;
					color: $gray1;
					border-radius: 2px;
					cursor: pointer;
					transition: all .2s;
					border: 1px solid #f3f3f5;
					&:hover{
						background-color: #dedede;
					}
				}
			}	
		}
	}
</style>