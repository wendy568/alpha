<template>
    <div class="payBack-mask">
        <div class="payBack-box">
            <!-- 图标 -->
            <i class="pic"></i>
            <!-- 文字 -->
            <div class="text">
                pay success!
            </div>
            <!-- 跳转到myorder -->
            <router-link to="/personal/order" class="link">
                Check my order
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .payBack-mask{
        width: 100%;
        height: 100%;
        .payBack-box{
            width: 200px;
            // height: 200px;
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
    }
</style>