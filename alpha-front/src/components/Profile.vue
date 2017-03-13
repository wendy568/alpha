<template>
    <div class="pro-box">
        <form class="pro-form">
            <div class="pro-nic">
                <label for="nic">
                    Nickname
                </label>
                <input @change="checkNic" name="nic" class="input-small" type="text" placeholder="如：用户001" v-model="nic" required/>
            </div>
            <div class="pro-name">
                <label for="name">
                    Name
                </label>
                <input @change="checkFullName" name="name" class="input-small" type="text" placeholder="如：用户001" v-model="full_name" required/>
            </div>
            <div class="pro-phone">
                <label for="phone">
                    Phone
                </label>
                <input @change="checkPhone" name="phone" class="input-large" type="phone" placeholder="07896543234" v-model="phone" required/>
            </div>
            <div class="pro-email">
                <label for="email">
                    E-mail
                </label>
                <input @change="checkEmail" name="email" class="input-large" type="email" placeholder="flyme@163.com" v-model="email" required/>
            </div>
            <div class="pro-pwd">
                <label for="pwd">
                    Password
                </label>
                <input @change="checkPwd" name="pwd" class="input-large" type="password" v-model="pwd" required/>
            </div>
            <div class="pro-save">
                <div class="pro-save-box">
                    <button class="pro-save-btn">
                        <i class="pro-save-btn-icon">
                        
                        </i>
                        <span class="pro-save-btn-text">
                            Save
                        </span>
                    </button>
                    <a class="pro-reset" @click="reset">
                        Reset all
                    </a>
                </div>
            </div>
            <p class="pro-error">
                {{error}}
            </p>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                nic: '',
                full_name: '',
                phone: '',
                email: '',
                pwd: '',
                error: ''
            }
        },
        mounted() {
            const self = this
            self.nic = self.$store.state.nic_name
            self.email = self.$store.state.email
        },
        methods: {
            reset() {
                const self = this
                self.nic = ''
                self.name = ''
                self.phone = ''
                self.email = ''
                self.pwd = ''
            },
            checkEmail() {
                const self = this
            },
            checkFullName() {
                const self = this
            },
            checkPwd() {
                const self = this
            },
            checkPhone() {
                const self = this
                const reg = /^\+?[1-9][0-9]*$/
                if(!reg.test(self.phone)){
                    self.error = 'Incorrect phone format'
                }else{
                    self.error = ''
                }
            },
            checkNic() {
				const self = this
				const reg = /((?=[\x21-\x7e]+)[^A-Za-z0-9])/
				let len = 0
				for(let i = 0; i < self.nic.length; i ++) {
					if(self.nic.charCodeAt(i) > 127 || self.nic.charCodeAt(i) === 94) {
						len += 2
					}else{
						len ++
					}
				}
				if(self.nic == '') {
					self.error = 'Nickname cannot be empty'
				}else if(reg.test(self.nic)){
					self.error = 'Nickname cannot contain special symbols'
				}else if(len > 20){
					self.error = 'Nickname length can not be greater than 20 characters'
				}else{
					self.error = ''
				}
			}
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';

    $inputheight: 36px;

    .pro-box{
        padding: 20px 0;
        .pro-form{
            width: 600px;
            margin: 0 auto;
            color: $gray3;
            font-size: 14px;
            .pro-nic,.pro-name,.pro-phone,.pro-email,.pro-pwd{
                width: 100%;
                float: left;
                padding: 15px 0;
                box-sizing: border-box;
                line-height: $inputheight;
                label{
                    width: 15%;
                    text-align: right;
                    float: left;
                    padding-right: 10px;
                    box-sizing: border-box;
                }
                input{
                    box-sizing: border-box;
                    width: 85%;
                    float: left;
                    border: 1px solid $gray5;
                    border-radius: 2px;
                    height: $inputheight;
                    padding-left: 10px;
                    outline: none;
                    &:focus{
                        border-color: $primary;
                    }
                }
                .input-small{
                    width: 30%;
                }
            }
            .pro-error{
                color: $danger;
                margin: 0;
                width: 100%;
                height: 30px;
                float: left;
                padding-left: 15%;
                box-sizing: border-box;
            }
            .pro-save{
                width: 100%;
                float: left;
                padding: 15px 0;
                box-sizing: border-box;
                line-height: $inputheight;
                .pro-save-box{
                    width: 85%;
                    float: right;
                    .pro-save-btn{
                        border: none;
                        outline: none;
                        cursor: pointer;
                        background: $primary;
                        color: #fff;
                        width: 100px;
                        height: $inputheight;
                        line-height: $inputheight;
                        text-align: center;
                        border-radius: 2px;
                        font-size: 14px;
                        .pro-save-btn-icon{

                        }
                        .pro-save-btn-text{

                        }
                    }
                    .pro-reset{
                        cursor: pointer;
                        padding: 0 10px;
                    }
                }
            }
        }
    }
</style>