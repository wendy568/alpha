<template>
    <div class="ap-box">
        // <iframe name="alipay" id="alipay" src="" frameborder="0" v-show="$store.state.show_alipay"></iframe>
        <div class="ap-dialog">
            <i class="ap-close" @click="close">
				<s class="ap-close-line"></s>
			</i>
            <div class="ap-header">
                <i class="ap-header-icon"></i>
            </div>
            <div class="ap-content">
                <p class="ap-amount">
                    <span class="ap-amount-key">Total Amount:</span>
                    <span class="ap-amount-val">￡{{$store.state.pay_info.price}}</span>
                </p>
            </div>
            <ul class="ap-types">
                <li class="ap-types-item" v-for="item,$key in $store.state.pay_types" :key="$key">
                    <div class="ap-types-item-icon"></div>
                    <p class="ap-types-item-name">
                        {{item.name}}
                    </p>
                    <p class="ap-types-item-status">
                        <span @click="togglePayStatus('on',item.name)" class="ap-types-item-status-on" v-if="item.status"></span>
                        <span @click="togglePayStatus('off',item.name)" class="ap-types-item-status-off" v-else></span>
                    </p>
                </li>
            </ul>
            <div class="ap-next">
                <button class="ap-next-btn " @click="openBack($store.state.pay_info.price)">
                    Next
                </button>
            </div>
        </div>

        <div class="ap-confirm" v-if="show_payconfirm">
            <div class="ap-confirm-dialog">
                <div class="ap-confirm-info">
                    付款成功后请点击下面按钮“付款成功”
                </div>
                <div class="ap-confirm-btns">
                    <button class="ap-confirm-btn" @click="checkPay">
                        付款成功
                    </button>
                    <button @click="failedPay" class="ap-confirm-btn">
                        付款失败
                    </button
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                show_payconfirm: false,
                order_id: 0,
                order_no: ''
            }
        },
        methods: {
            close() {
				const self = this
				self.$store.dispatch('TOGGLEACTPAY','off')
			},
            togglePayStatus(status,value) {
                const self = this
                self.$store.dispatch('TOGGLEPAYSTATUS',value)
            },
            failedPay() {
                const self = this
                self.show_payconfirm = false
            },
            checkPay() {
                const self = this
                let formData = new FormData()
                formData.append('token',sessionStorage.getItem('token'))
                formData.append('table','event_order')
                formData.append('out_trade_no',sessionStorage.getItem('order_no'))
                fetch(self.$store.state.api_addr + 'order/is_payment',{
                    method: 'post',
                    mode: 'cors',
                    body: formData
                }).then((res) => {
                    res.ok && res.json().then((json) => {
                        switch(json.archive.status){
                            case 0:
                                self.$store.dispatch('TOGGLETIP','Payment success')
                                self.$router.push({path:'/personal/order/event_order'})
                                self.$store.dispatch('TOGGLEACTPAY','off')
                            case 113:
                                self.$store.dispatch('TOGGLETIP','Payment failed')
                        }
                    })
                })
            },
            openBack(price) {
                const self = this
                let formData = new FormData()
                formData.append('event_id',self.$store.state.act_id)
                formData.append('num',1)
                formData.append('price',price)
                formData.append('payment',1)
                formData.append('token',sessionStorage.getItem('token'))
                formData.append('info',self.activity_detail)
                formData.append('table','event_order')
                self.show_payconfirm = !self.show_payconfirm
                fetch(self.$store.state.api_addr + 'order/create_order',{
                    mode: 'cors',
                    method: 'post',
                    body: formData
                }).then((res) => {
                    res.ok && res.json().then((json) => {
                        if(json.archive.status === 0){
                            self.order_id = json.data.event_order_id
                            self.order_no = json.data.event_order_no
                            sessionStorage.setItem('order_id',json.data.event_order_id)
                            sessionStorage.setItem('order_no',json.data.event_order_no)
                            // self.$store.dispatch('TOGGLEALIPAY','on')
                            // document.getElementById('alipay').src = self.$store.state.api_addr + 'payment/alipay?WIDout_trade_no=' + sessionStorage.getItem('order_no') + '&WIDsubject=chenqitest&currency=GBP&WIDtotal_fee=' + price
                            
                            window.open(self.$store.state.api_addr + 'payment/alipay?WIDout_trade_no=' + sessionStorage.getItem('order_no') + '&WIDsubject=chenqitest&currency=GBP&WIDtotal_fee=' + price)

                        }else if(json.archive.status === 400){

                        }
                    })
                })
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .ap-box{
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(230,240,250,.9);
        z-index: 999;
        #alipay{
            position: fixed;
            background: #fff;
            left: 50%;
            top: 150px;
            margin-left: -500px;
            width: 1000px;
            height: 500px;
            border-radius: 3px;
            box-shadow: 0 0 50px 15px rgba(0,0,0,.2);
            border: 1px solid rgba(0,0,0,.2);
            box-sizing: border-box;
            z-index: 1003;
        }
        .ap-confirm{
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.7);
            z-index: 1000;
            .ap-confirm-dialog{
                position: absolute;
                left: 50%;
                top: 30%;
                margin-left: -250px;
                width: 500px;
                height: 300px;
                background: #fff;
                text-align: center;
                border-radius: 3px;
                z-index: 1001;
                box-shadow: 0 0 50px 18px rgba(0,0,0,.1);
                .ap-confirm-info{
                    width: 100%;
                    hight: 50%;
                    padding: 80px 30px;
                    box-sizing: border-box;
                }
                .ap-confirm-btns{
                    width: 60%;
                    overflow: hidden;
                    margin: 0 auto;
                    height: 50%;
                    padding: 30px;
                    box-sizing: border-box;
                    .ap-confirm-btn{
                        outline: none;
                        border: none;
                        width: 80px;
                        cursor: pointer;
                        height: 36px;
                        float: left;
                        margin: 0 20px;
                        border-radius: 5px;
                        background: $primary;
                        color: #fff;
                    }
                }
            }
        }
        .ap-dialog{
            position: relative;
            width: 600px;
            margin: 100px auto;
            background: #fff;
            z-index: 999;
            .ap-close{
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
                .ap-close-line{
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
            .ap-header{
                width: 100%;
                height: 100px;
                position: relative;
                background-image: url(../assets/images/pay_header.png);
                background-size: 100% 100%;
                background-position: center center;
                background-repeat: no-repeat;
                .ap-header-icon{
                    display: block;
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    background-image: url(../assets/images/pay_header_icon.png);
                    background-size: 40px;
                    background-position: center center;
                    background-repeat: no-repeat;
                }
            }
            .ap-content{
                padding: 30px 0;
                .ap-amount{
                    margin: 0;
                    text-align: center;
                    .ap-amount-key{

                    }
                    .ap-amount-val{
                        color: $danger;
                        font-weight: 900;
                    }
                }
            }
            .ap-types{
                width: 100%;
                padding: 0 40px;
                box-sizing: border-box;
                overflow: hidden;
                margin: 0;
                .ap-types-item{
                    width: 33.3%;
                    float: left;
                    text-align: center;
                    .ap-types-item-icon{
                        margin: 0 auto;
                        margin-bottom: 15px;
                        width: 50px;
                        height: 50px;
                        display: block;
                        background-size: 100%;
                        background-repeat: no-repeat;
                        background-position: center center;
                    }
                    .ap-types-item-name{
                        margin: 0 auto;
                        padding-bottom: 20px;
                    }
                    .ap-types-item-status{
                        margin: 0 auto;
                        .ap-types-item-status-on,.ap-types-item-status-off{
                            cursor: pointer;
                            width: 30px;
                            height: 30px;
                            display: block;
                            margin: 0 auto;
                            background-size: 100%;
                            background-position: center center;
                            background-repeat: no-repeat;
                        }
                        .ap-types-item-status-on{
                            background-image: url(../assets/images/pay_on.png);
                        }
                        .ap-types-item-status-off{
                            background-image: url(../assets/images/pay_off.png);
                        }
                    }
                    &:first-child{
                        .ap-types-item-icon{
                            background-image: url(../assets/images/alipay.png);
                        }
                    }
                    &:nth-child(2){
                        .ap-types-item-icon{
                            background-image: url(../assets/images/alpha_icon_pay_paypal.png);
                        }
                    }
                    &:last-child{
                        .ap-types-item-icon{
                            background-image: url(../assets/images/alpha_icon_pay_ddtransfer.png);
                        }
                    }
                }
            }
            .ap-next{
                padding: 40px 0;
                .ap-next-btn{
                    display: block;
                    margin: 0 auto;
                    width: 80px;
                    height: 30px;
                    border-radius: 3px;
                    border: none;
                    outline: none;
                    text-align: center;
                    line-height: 30px;
                    color: #fff;
                    background: $primary;
                    cursor: pointer;
                    text-decoration: none;
                }
            }
        }
    }
</style>