<template>
	<div class="login-mask">
		<div class="model" @click="close"> </div>
		<div class="login-box">
			<i class="login-close" @click="close">
				<s class="login-close-line"></s>
			</i>
			<div class="login-left">
				
			</div>
			<div class="login-right">
				<div class="login-logo"></div>
				<div class="login-form" @keyup.enter="login">
					<input v-model="email" @change="checkEmail" class="login-email" type="text" placeholder="E-mail">
					<input v-model="pwd" @change="checkPwd" class="login-pwd" type="password" placeholder="Password">
					<div class="login-options">
						<input v-model="isRemmenber" class="login-checkbox checkbox" id="remmenber" name="remmenber" type="checkbox">
						<label class="login-label" for="remmenber">Remenber</label>
						<a class="login-forget">Forget Password</a>
					</div>
					<button @click="login" class="login-submit">Login</button>
					<p class="login-extra">
						Dont't have a Account?
						<a @click="change">Sign up now</a>
					</p>
				</div>
				<p class="login-error">
					{{error}}
				</p>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				error: '',
				email: '',
				pwd: '',
				isRemmenber: true
			}
		},
		methods: {
			close() {
				const self = this
				self.$store.dispatch('TOGGLELOGIN','off')
			},
			change() {
				const self = this
				self.$store.dispatch('TOGGLEREGISTER')
			},
			checkEmail() {
				const self = this
				const reg = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/
				if(self.email == '') {
					self.error = 'Email cannot be empty'
				}else if(!reg.test(self.email)){
					self.error = 'Incorrect E-mail format'
				}else{
					self.error = ''
				}
			},
			checkPwd() {
				const self = this
				const reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/
				if(!self.pwd) {
					self.error = 'Password cannot be empty'
				}else if(!reg.test(self.pwd)){
					self.error = 'Password for 8-16 bit numbers and English combinations'
				}else{
					self.error = ''
				}
			},
			login() {
				const self = this
				if(self.email || self.pwd){
					let formData = new FormData()
					formData.append('email',self.email)
					formData.append('password',self.pwd)
					fetch(self.$store.state.api_addr + 'user/login',{
						method: 'post',
						mode: 'cors',
						body: formData
					}).then((res) => {
						if(res.ok) {
							res.json().then((json) => {
								if(json.archive.status === 0) {
									sessionStorage.setItem('token',json.data.token)
									let user = {
										email: self.email
									}
									self.$store.dispatch('TOGGLEONLINE','on')
									self.$store.dispatch('STORAGEUSERINFO',user)
									self.close()
								}else{
									self.error = 'Account or password is wrong!'
									self.pwd = ''
								}
							})
						}	
					})
					if(self.isRemmenber === true) {
						localStorage.setItem('email',escape(self.email))
						localStorage.setItem('token',escape(json.data.token))
					}else{
						localStorage.removeItem('email')
						localStorage.removeItem('token')
					}
				}else{
					self.error = 'Password cannot be empty！'
				}
			}
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.login-mask{
		position: fixed;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background: rgba(0,0,0,.6);
		z-index: 1;
		.model{
            position: absolute;
            width: 100%;
            height: 100%;
            z-index:100;
        }
		.login-box{
			position: absolute;
			left: 50%;
			top: 110px;
			width: 700px;
			height: 420px;
			margin-left: -350px;
			background: #fff;
			border-radius: 2px;
			box-shadow: 0 0 10px rgba(0,0,0,.18);
			z-index: 2000;
			color: $gray3;
			.login-close{
				position: absolute;
				right: 15px;
				top: -50px;
				width: 30px;
				height: 30px;
				background-image: url(../assets/images/close.png);
				background-position: center center;
				background-repeat: no-repeat;
				background-size: 100% 100%;
				cursor: pointer;
				.login-close-line{
					width: 2px;
					height: 20px;
					position: absolute;
					bottom: -20px;
					left: 50%;
					margin-left: -1px;
					background-color: $gray3;
				}
				&:hover{
					color: $gray3;
				}
			}
			.login-left{
				float: left;
				background-image: url(../assets/images/login.png);
				background-position: center center;
				background-size: 100% 100%;
				background-repeat: no-repeat;
				width: 270px;
				height: 100%;
			}
			.login-right{
				float: left;
				width: 430px;
				height: 100%;
				background: #fff;
				padding: 80px 50px 0 50px;
				box-sizing: border-box;
				.login-logo{
					background: url(../assets/images/alpha_logo.png) center center no-repeat;
					background-size: 50%;
					width: 100%;
					height: 40px;
				}
				.login-form{
					width: 100%;
					overflow: hidden;
					padding-top: 40px;
					box-sizing: border-box;
					.login-email{
						float: left;
						width: 100%;
						height: 36px;
						line-height: 36px;
						color: $gray3;
						border: 1px solid $gray5;
						outline: none;
						text-align: center;
						border-radius: 5px;
						box-sizing: border-box;
						margin-bottom: 15px;
					}
					.login-pwd{
						float: left;
						width: 100%;
						height: 36px;
						line-height: 36px;
						color: $gray3;
						border: 1px solid $gray5;
						outline: none;
						text-align: center;
						border-radius: 5px;
						box-sizing: border-box;
					}
					.login-options{
						width: 100%;
						padding: 10px 0;
						color: $gray3;
						overflow: hidden;
						float: left;
						box-sizing: border-box;
						font-size: 14px;
						line-height: 14px;
						.login-checkbox{
							float: left;
							width: 16px;
							height: 16px;
						}
						.login-label{
							float: left;
							padding-left: 10px;
							cursor: pointer;
						}
						.login-forget{
							float: right;
							text-decoration: none;
							color: $gray3;
							cursor: pointer;
						}
					}
					.login-submit{
						outline: none;
						border: none;
						width: 100%;
						height: 36px;
						border-radius: 5px;
						background-color: $primary;
						color: #fff;
						text-align: center;
						line-height: 36px;
						float: left;
						cursor: pointer;
					}
					.login-extra{
						width: 100%;
						overflow: hidden;
						color: $gray3;
						font-size: 14px;
						text-align: center;
						padding: 15px 0;
						box-sizing: border-box;
						cursor: pointer;
						&>a{
							color: $primary;
						}
					}
				}
				.login-error{
					margin: 0;
					text-align: center;
					color: $danger;
				}
			}
		}
	}
</style>