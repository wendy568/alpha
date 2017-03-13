<template>
    <div class="tip-box">
        <div class="tip-text">
            {{$store.state.tip.text}}
        </div>
        <div class="tip-option">
            <button class="tip-btn" @click="$store.dispatch('TOGGLETIP')">
                OK
            </button>
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
    .tip-box{
        width: 300px;
        height: 160px;
        position: fixed;
        left: 50%;
        top: 200px;
        margin-left: -150px;
        background: #fff;
        z-index: 1000;
        border-radius: 3px;
        box-shadow: 0 0 50px 18px rgba(0,0,0,.18);
        color: #333;
        text-align: center;
        line-height: 2;
        .tip-text{
            width: 100%;
            height: 100px;
            padding: 20px;
            box-sizing: border-box;
        }
        .tip-option{
            width: 100%;
            height: 50px;
            .tip-btn{
                width: 80px;
                height: 40px;
                margin: 10px auto;
                border: none;
                outline: none;
                background: $primary;
                color: #fff;
                border-radius: 3px;
                cursor: pointer;
                &:hover{
                    background: $info;
                }
            }
        }
    }
</style>