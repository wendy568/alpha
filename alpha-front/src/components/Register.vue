<template>
	<div class="register-mask">
		<div class="model" @click="close"> </div>
		<div class="register-box">
			<i class="register-close" @click="close">
				<s class="register-close-line"></s>
			</i>
			<div class="register-left">
				
			</div>
			<div class="register-right">
				<div class="register-logo"></div>
				<div class="register-form" @keyup.enter="register">
					<p class="register-error">
						{{error}}
					</p>
					<!-- 注册邮箱 -->
					<input v-model="email" @change="checkEmail" class="register-email" type="text" placeholder="Email">
					<!-- 设置密码 -->
                    <div class="register-pwd">
                        <input v-if="show_pwd" @change="checkPwd" id="reg-pwd" class="register-pwd-input" type="text" placeholder="Password" v-model="pwd">
                        <input v-else @change="checkPwd" id="reg-pwd" class="register-pwd-input" type="password" placeholder="Password" v-model="pwd">
                        <label @click="togglepwd" for="reg-pwd" class="register-pwd-label" :class="{ 'register-pwd-visible': show_pwd }"></label>
                    </div>
                    <div class="register-pwd">
                        <input v-if="show_pwd" @change="checkPwd" id="reg-pwd" class="register-pwd-input" type="text" placeholder="Password" v-model="cpwd">
                        <input v-else @change="checkPwd" id="reg-pwd" class="register-pwd-input" type="password" placeholder="Confirm Password" v-model="cpwd">
                        <label @click="togglepwd" for="reg-pwd" class="register-pwd-label" :class="{ 'register-pwd-visible': show_pwd }"></label>
                    </div>
					<!-- radio -->
					<div class="register-options">
						<input class="register-checkbox checkbox" id="remmenber" name="remmenber" type="checkbox">
						<label class="register-label" for="remmenber">View and accept Alpha terms of service</label>
					</div>
					<!-- Register -->
					<button @click="register" class="register-submit">Register</button>
					<p class="register-extra">
						Existing account?
						<a @click="change">immediately</a>
					</p>
				</div>
				
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
                show_pwd: false,
				email: '',
				pwd: '',
				cpwd: '',
				error: ''
			}
		},
        computed: {
            pwd_status () {
                return this.show_pwd ? 'text' : 'password'
            }
        },
		methods: {
			close() {
				let self = this
				self.$store.dispatch('TOGGLEREGISTER','off')
			},
			change() {
				let self = this
				self.$store.dispatch('TOGGLELOGIN')
			},
            togglepwd() {
                let self = this
                self.show_pwd = !self.show_pwd

            },
			checkEmail() {
				const self = this
				const reg = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/
				if(self.email == '') {
					self.error = 'E-mail cannot be empty'
				}else if(!reg.test(self.email)){
					self.error = 'Incorrect E-mail format'
				}else if(self.pwd !== self.cpwd){
					self.error = ''
				}
			},
			checkPwd() {
				const self = this
				const reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/
				if(self.pwd && self.cpwd == '') {
					self.error = 'Password cannot be empty'
				}else if(!reg.test(self.pwd)&&!reg.test(self.cpwd)){
					self.error = 'Password for 8-16 bit numbers and English combinations'
				}else if(self.pwd !== self.cpwd){
					self.error = 'Password must agree and confirm password'
				}else{
					self.error=''
				}
			},
			register() {
				const self = this
				let formData = new FormData()
				formData.append('email',self.email)
				// formData.append('first_name',self.first)
				formData.append('password',self.pwd)
				fetch(self.$store.state.api_addr + 'user/register',{
					method: 'post',
					mode: 'cors',
					body: formData
				}).then((res) => {
					if(res.ok) {
						res.json().then((json) => {
							if(json.archive.status === 0) {
								// sessionStorage.setItem('token',json.data.token)
								let user = {
									// first_name: self.first,
									email: self.email
								}
								self.$store.dispatch('TOGGLEONLINE','on')
								self.$store.dispatch('STORAGEUSERINFO',user)
								self.error = 'To register, please login'
								// self.close()
							}else{
								self.error = 'Registration failed, please register again'
							}
						})
					}	
				})
			}
		}
	}
</script>

<style lang="scss">
	@import '../css/alpha.scss';
	.register-mask{
		position: absolute;
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
		.register-box{
			position: absolute;
			left: 50%;
			top: 160px;
			width: 700px;
			height: 420px;
			margin-left: -350px;
			background: #fff;
			border-radius: 2px;
			box-shadow: 0 0 10px rgba(0,0,0,.18);
			z-index: 2000;
            color: $gray3;
			.register-close{
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
				.register-close-line{
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
			.register-left{
				float: left;
				background-image: url(../assets/images/login.png);
				background-position: center center;
				background-size: 100% 100%;
				background-repeat: no-repeat;
				width: 270px;
				height: 100%;
			}
			.register-right{
				float: left;
				width: 430px;
				height: 100%;
				background: #fff;
				padding: 80px 50px;
				box-sizing: border-box;
				.register-logo{
					background-image: url(../assets/images/logo.png);
					background-repeat: no-repeat;
					background-position: center center;
					width: 100%;
					height: 40px;
				}
				.register-form{
					width: 100%;
					overflow: hidden;
					box-sizing: border-box;
					.register-error{
						margin: 0;
						text-align: center;
						color: $danger;
						height: 40px;
						line-heiht: 40px;
					}
					.register-first{
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
                    .register-email{
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
					.register-pwd{
						float: left;
                        overflow: hidden;
                        position: relative;
                        width: 100%;
                        .register-pwd-input{
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
                        .register-pwd-label{
                            position: absolute;
                            right: 10px;
                            top: 10px;
                            display: block;
                            width: 16px;
                            height: 16px;
                            background-image: url(../assets/images/hidden.png);
                            background-position: center center;
                            background-size: 100%;
                            background-repeat: no-repeat;
                            cursor: pointer;
                        }
                        .register-pwd-visible{
                            background-image: url(../assets/images/visible.png);
                        }
					}
                    
					.register-options{
						width: 100%;
						padding: 10px 0;
						color: $gray3;
						overflow: hidden;
						float: left;
						box-sizing: border-box;
						font-size: 14px;
						line-height: 14px;
						.register-checkbox{
							float: left;
							width: 16px;
							height: 16px;
						}
						.register-label{
							float: left;
							padding-left: 10px;
						}
					}
					.register-submit{
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
					.register-extra{
						width: 100%;
						overflow: hidden;
						color: $gray3;
						font-size: 14px;
						text-align: center;
						padding: 10px 0;
						margin: 0;
						box-sizing: border-box;
						&>a{
							color: $primary;
							cursor: pointer;
						}
					}
				}
			}
		}
	}
</style>