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
            fetch(self.$store.state.api_addr+'order/handler_order?'+location.href.split('?')[1],{
                method: 'get'
            }).then((res) => {
                res.ok && res.json().then((json) => {
                    switch(json.archive.status){
                        case 0:
                            console.log(json.archive.status)
                            self.$store.dispatch('TOGGLETIP','Pay success')
                        case 112:
                            self.$store.dispatch('TOGGLETIP','Pay failed')
                    }
                })
            })
        },
        methods:{
           paySucc(){
                self.$router.push({path:self.$store.state.api_addr+'/personal/order/event_order'})
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