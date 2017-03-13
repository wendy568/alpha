<template>
    <div class="zp-box">
        <zp_form v-if="$store.state.show_zpform"></zp_form>
        <div class="zp-top">
            <div class="zp-wrp">
                <div class="zp-info">
                    <p class="zp-info-content">
                        <b class="zp-info-content-one">
                            A
                        </b>
                        lpha Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader
                    </p>
                </div>
                <ul class="zp-model">
                    <li class="zp-model-item" v-for="item in models">
                        <h3 class="zp-model-item-title">
                            {{item.title}}
                        </h3>
                        <p class="zp-model-item-intro">
                            {{item.intro}}
                        </p>
                        <p class="zp-model-item-icon">
                            <span class="zp-model-item-icon-img">
                            
                            </span>
                        </p>
                        <p class="zp-model-item-content">
                            {{item.content}}
                        </p>
                        <p class="zp-model-item-option">
                            <button class="zp-model-item-apply">
                                Apply
                            </button>
                        </p>
                        <p class="zp-model-item-des">
                            {{item.des}}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="zp-bottom">
            <div class="zp-bottom-mask">
                <button class="zp-bottom-apply">
                    Apply Now
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                models: [
                    { title: 'Prop-trading Model',intro: '引领自营交易从开始到顶峰的培养模式',price: 999.00,content: '线下18课时专业培训计划',des: '自营模式是一种现代电子交易形式，公司或金融机构使用自己的资本和资产负债表在自己的账户上进行交易。公司和金融机构提供一个专业系统额资金账户，帮助交易员成长。交易员自己不需要寻找介乎或资金，有公司自己承担所有的交易收益或亏损' },
                    { title: 'Prop-trading Model',intro: '引领自营交易从开始到顶峰的培养模式',price: 999.00,content: '线下18课时专业培训计划',des: '自营模式是一种现代电子交易形式，公司或金融机构使用自己的资本和资产负债表在自己的账户上进行交易。公司和金融机构提供一个专业系统额资金账户，帮助交易员成长。交易员自己不需要寻找介乎或资金，有公司自己承担所有的交易收益或亏损' }
                ]
            }
        },
        components: {
            'zp_form': function(resolve) {
                require(['./Zp_form'], resolve)
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .zp-box{
        width: 100%;
        overflow: hidden;
        .zp-top{
            background-image: url(../assets/images/act_banner.jpg);
            background-position: top center;
            background-repeat: no-repeat;
            background-size: 100%;
            padding: 180px 150px;
            overflow: hidden;
            min-height: 1000px;
            .zp-wrp{
                width: 1140px;
                margin: 0 auto;
                .zp-info{
                    width: 65%;
                    background: rgba(0,0,15,.7);
                    color: #fff;
                    padding: 5px;
                    margin-bottom: 50px;
                    .zp-info-content{
                        padding: 20px 30px 0 60px;
                        font-size: 14px;
                        line-height: 2 ;
                        box-sizing: border-box;
                        .zp-info-content-one{
                            font-size: 40px;
                            font-weight: 400;
                            line-height: 20px;
                        }
                    }
                }
                .zp-model{
                    width: 100%;
                    background: transparent;
                    padding: 0;
                    margin: 0;
                    font-size: 14px;
                    .zp-model-item{
                        padding: 50px 70px;
                        text-align: center;
                        border: 1px solid $gray5;
                        width: 550px;
                        min-height: 300px;
                        background: #fff;
                        float: left;
                        box-sizing: border-box;
                        cursor: pointer;
                        &:first-child{
                            margin-right: 40px;
                        }
                        &:hover{
                            box-shadow: 0 50px 50px 0 rgba(0,0,0,.05);
                        }
                        .zp-model-item-title{
                            color: $primary;
                            font-size: 20px;
                            font-weight: 400;
                            background-image: url(../assets/images/zplus_arrow.png);
                            background-repeat: no-repeat;
                            background-size: 18%;
                            background-position: bottom center;
                            margin: 0;
                            padding-bottom: 20px;
                        }
                        .zp-model-item-intro{
                            margin: 0;
                            color: $gray3;
                            padding: 15px 0;
                        }
                        .zp-model-item-icon{
                            margin: 0;
                            padding: 0;
                            .zp-model-item-icon-img{

                            }
                        }
                        .zp-model-item-content{
                            margin: 0;
                            padding: 0;
                            color: $gray3;
                            padding: 15px 0;
                        }
                        .zp-model-item-option{
                            margin: 0;
                            padding: 0;
                            .zp-model-item-apply{
                                width: 100px;
                                height: 32px;
                                border-radius: 1px;
                                outline: none;
                                cursor: pointer;
                                color: $primary;
                                background: transparent;
                                border: 1px solid $primary;
                                transition: all .2s;
                                &:hover{
                                    color: #fff;
                                    background: $primary;    
                                }
                            }
                        }
                        .zp-model-item-des{
                            margin: 0;
                            padding: 0;
                            color: $gray2;
                            padding: 15px 0;
                            line-height: 1.5;
                        }
                    }
                }
            }
        }
        .zp-bottom{
            width: 100%;
            height: 200px;
            overflow: hidden;
            background-image: url(../assets/images/zone_bottom.png);
            background-size: 100%;
            background-position: center center;
            background-repeat: no-repeat;
            .zp-bottom-mask{
                padding-top: 80px;
                .zp-bottom-apply{
                    display: block;
                    margin: 0 auto;
                    width: 200px;
                    height: 40px;
                    border: 1px solid #fff;
                    border-radius: 2px;
                    background: transparent;
                    color: #fff;
                    outline: none;
                    cursor: pointer;
                }
            }
        }
    }
</style>