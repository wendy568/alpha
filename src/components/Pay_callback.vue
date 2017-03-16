<template>
    <div class="payBack-mask">
        <div class="payBack-succ" v-if="success">
            <!-- 图标 -->
            <i class="pic"></i>
            <!-- 文字 -->
            <div class="text">pay success!</div>
            <!-- 跳转到myorder -->
            <span class="link" @click="paySucc">
                Check my order
            </span>
        </div>
        <!-- <div class="payBack-fail" v-else> -->
            <!-- 图标 -->
            <!-- <i class="pic"></i> -->
            <!-- 文字 -->
            <!-- <div class="text">pay fail!</div> -->
            <!-- 跳转到myorder -->
            <!-- <span class="link" @click="payFail">
                Check my order
            </span>
        </div> -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                success:true
            }
        },
        mounted() {
            const self = this
            let formData = new FormData()
            function success() {
                self.success= true
                setTimeout(function() {
                    self.$router.push({path: '/order/event_order'})
                },300)
            }
            location.href.split('?')[1] && sessionStorage.setItem('handle_params2',location.href.split('?')[1])
            location.href.split('?')[1] && showPayDeal()
            location.href.split('?')[1] && fetch(self.$store.state.api_addr + 'order/handler_order?' + sessionStorage.getItem('handle_params2'),{
                method: 'get'
            }).then((res) => {
                res.ok && res.json().then((json) => {
                    sessionStorage.setItem('payment_token',json.payment_token)
                    switch(json.archive.status){
                        case 0:
                            let formData = new FormData()
                            formData.append('token',sessionStorage.getItem('token'))
                            formData.append('status',1)
                            formData.append('payment_token',sessionStorage.getItem('payment_token'))
                            fetch(self.$store.state.api_addr + 'order/pay_order?' + sessionStorage.getItem('handle_params2'),{
                                method: 'post',
                                mode: 'cors',
                                body: formData
                            }).then((res) => {
                                self.$store.dispatch('TOGGLETIP','Pay success')
                            })
                            break;
                        case 112:
                            let formData2 = new FormData()
                            formData.append('token',sessionStorage.getItem('token'))
                            formData.append('status',2)
                            formData.append('payment_token',sessionStorage.getItem('payment_token'))
                            fetch(self.$store.state.api_addr + 'order/pay_order?' + sessionStorage.getItem('handle_params2'),{
                                method: 'post',
                                mode: 'cors',
                                body: formData2
                            }).then((res) => {

                            })
                            break;
                    }
                })
            })

            formData.append('token',sessionStorage.getItem('token'))
            formData.append('start',0)
            formData.append('limit',20)
            fetch(self.$store.state.api_addr + 'activity/activity_order_list',{
                mode: 'cors',
                method: 'post',
                body: formData
            }).then((res) => {
                res.ok && res.json().then((json) => {
                    self.orders = json.data
                })
            })
        },
        methods:{
           paySucc(){
                self.$router.push({path: '/order/event_order'})
           },
           payFail(){
                self.$store.dispatch('TOGGLEACTPAY','on')
           }
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .payBack-mask{
        width: 100%;
        height: 100%;
        .payBack-succ{
            width: 200px;
            margin:0 auto;
            display: block;
            vertical-align: middle;
            overflow: hidden;
            .pic{
                width: 90px;
                height: 90px;
                background:url(../assets/images/pay_success.png) center center no-repeat;
                background-size: 100% 100%;
                display: block;
                margin:200px auto 30px;
            }
            .text{
                font-size: 24px;
                color: $success;
                margin-top: 30px;
                text-align: center;
            }
            .link{
                text-decoration: none;
                color: $gray2;
                display: block;
                margin:20px auto;
                text-align: center;
                &:hover{
                    color: $success;
                    transition: all .4s; 
                }
            }
        }
        .payBack-fail{
            width: 200px;
            margin:0 auto;
            display: block;
            vertical-align: middle;
            overflow: hidden;
            .pic{
                width: 90px;
                height: 90px;
                background:url(../assets/images/pay_fail.png) center center no-repeat;
                background-size: 100% 100%;
                display: block;
                margin:200px auto 30px;
            }
            .text{
                font-size: 24px;
                color: $danger;
                margin-top: 30px;
                text-align: center;
            }
            .link{
                text-decoration: none;
                color: $gray2;
                display: block;
                margin:20px auto;
                text-align: center;
                &:hover{
                    color: $danger;
                    transition: all .4s; 
                }
            }
        }
    }
</style>