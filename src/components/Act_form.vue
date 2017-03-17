<template>
    <div class="af-box">
        <div class="af-dialog">
            <i class="af-close" @click="close">
                <s class="af-close-line"></s>
            </i>
            <!-- title -->
            <div class="af-header"> 活动报名</div>
            <!-- form -->
            <form class="af-form">
                <div class="af-name">
                    <label for="name">
                        FirstName
                    </label>
                    <input v-model="first_name" id="name" type="text" placeholder="Example: John">
                </div>
                <div class="af-phone">
                    <label for="phone">
                        Phone
                    </label>
                    <input v-model="phone" id="phone" type="text" placeholder="Example: 18988889999">
                </div>
                <div class="af-email">
                    <label for="email">
                        E-mail
                    </label>
                    <input v-model="email" id="email" type="text" placeholder="Example: alpha@gmail.com">
                </div>
                <div class="af-address">
                    <label for="address">
                        Company
                    </label>
                    <input v-model="addr" id='address' type="text" placeholder="Example: Alpha co">
                </div>
                <div class="af-position">
                    <label for="position">
                        Profession
                    </label>
                    <input  v-model="position" id='position' type="text" placeholder="Example: Trader">
                </div>
                <div class="af-cost">
                    <label for="cost">
                        Fee
                    </label>
                    <span>
                        ￡{{$store.state.pay_info.price}}
                    </span>
                </div>
                <div class="af-btns">
                    <button @click="openPay" class="af-submit btn-primary" type="button">
                        Next
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                phone: '',
                first_name: '',
                addr: '',
                position: ''
            }
        },
        methods: {
            close() {
                const self = this
                self.$store.dispatch('TOGGLEACTFORM','off')
            },
            openPay() {
                const self = this
                let formData = new FormData()
                formData.append('token',sessionStorage.getItem('token'))
                formData.append('first_name',self.first_name)
                formData.append('phone',self.phone)
                formData.append('pro',self.position)
                formData.append('organization',self.addr)
                self.$store.dispatch('CHANGEPAYTABLE','event_order')
                fetch(self.$store.state.api_addr + 'user/update_user_info',{
                    method: 'post',
                    mode: 'cors',
                    body: formData
                }).then((res) => {
                    res.ok && res.json().then((json) => {
                        json.archive.status === 0 && self.$store.dispatch('TOGGLEACTPAY','on')
                        self.$store.dispatch('TOGGLEACTFORM','off')
                    })
                })
                
            }
        },
        mounted() {
            const self = this
            let formData = new FormData()
            formData.append('token',sessionStorage.getItem('token'))
            fetch(self.$store.state.api_addr + 'user/user_info_center',{
                method: 'post',
                mode: 'cors',
                body: formData
            }).then((res) => {
                res.ok && res.json().then((json) => {
                    self.email = json.data.email
                    self.phone = json.data.phone
                    self.first_name = json.data.first_name
                    self.position = json.data.pro
                    self.addr = json.data.organization
                })
            })
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';

    $afheight: 36px;

    .af-box{
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(1,1,1,.5);
        z-index: 999;
        .af-dialog{
            position: relative;
            width: 600px;
            background: #fff;
            box-shadow: 0 0 18px rgba(0,0,0,.01);
            border-radius: 8px;
            margin:120px auto;
            .af-close{
                position: absolute;
                right: 0;
                top: -50px;
                width: 30px;
                height: 30px;
                background-image: url(../assets/images/close.png);
                background-position: center center;
                background-repeat: no-repeat;
                background-size: 100% 100%;
                cursor: pointer;
                .af-close-line{
                    width: 2px;
                    height: 20px;
                    position: absolute;
                    bottom: -20px;
                    left: 50%;
                    margin-left: -1px;
                    background-color: #fff;
                }
                &:hover{
                    color: $gray3;
                }
            }
            .af-header{
                width: 100%;
                overflow: hidden;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                line-height: 100px;
                color:$gray1;
            }
            .af-form{
                padding: 0 70px 30px;
                .af-name,.af-phone,.af-email,.af-address,.af-position,.af-cost{
                    padding-bottom: 20px;
                    overflow: hidden;
                    label{
                        width: 20%;
                        color: $gray1;
                        font-size: 14px;
                        font-weight: 600;
                        box-sizing: border-box;
                        padding-right: 10px;
                        line-height: $afheight;
                        text-align: right;
                        float: left;
                        overflow: hidden;
                    }
                    input{
                        width: 70%;
                        border: 1px solid $gray5;
                        border-radius: 3px;
                        padding-left: 10px;
                        box-sizing: border-box;
                        line-height: $afheight;
                        outline: none;
                        float: left;
                    }
                    span{
                        float: left;
                        line-height: $afheight;
                        width: 50%;
                        color: $danger;
                        font-weight: 900;
                    }
                }
                .af-cost{
                    padding: 0;
                }
                .af-btns{
                    width: 100%;
                    padding-top: 30px;
                    .af-submit{
                        margin: 0 auto;
                        display: block;
                        position: relative;
                    }
                }
                
            }
        }
    }
</style>