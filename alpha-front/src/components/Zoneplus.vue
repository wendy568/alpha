<template>
    <div class="zp-box">
        <zonep_form v-if="$store.state.show_zonepform"></zonep_form>
        <act_pay v-if="$store.state.show_actpay"></act_pay>

        <div class="zp-top">
            <div class="zp-wrp">
                <!-- 简介 -->
                <div class="zp-info">
                    <p class="zp-info-content">
                        <b class="zp-info-content-one">
                            A
                        </b>
                        lpha Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader
                    </p>
                </div>
                <!-- apply -->
                <ul class="zp-model">
                    <li class="zp-model-item" v-for="item in models">
                        <!-- 标题 -->
                        <h3 class="zp-model-item-title"> {{item.title}}</h3>
                        <!--介绍 -->
                        <p class="zp-model-item-intro">{{item.intro}}</p>
                        <!-- icon -->
                        <p class="zp-model-item-icon">
                            <span class="zp-model-item-icon-img"></span>
                        </p>
                        <!-- price -->
                        <p class="zp-model-item-sel">
                            <span class="zp-model-item-left">普通 ￡0.01/每月</span>
                            <span class="zp-model-item-right"> 高级 ￡0.02/每月</span>
                        </p>
                        <!-- 特色 -->
                        <div class="zp-model-item-content">
                            <p>{{item.content1}}</p>
                            <p>{{item.content2}}</p>
                            <p>{{item.content3}}</p>
                            <p>{{item.content4}}<span>[仅限高级]</span></p>
                            <p>{{item.content5}}<span>[仅限高级]</span></p>
                        </div>
                        <!-- apply按钮 -->
                        <p class="zp-model-item-option">
                            <button class="zp-model-item-apply" @click="pay"> Apply </button>
                        </p>
                        <!-- 按钮下的一段话 -->
                        <p class="zp-model-item-des">
                            {{item.des}}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <!-- footer -->
        <div class="zp-bottom">
            <div class="zp-bottom-mask">
                <button class="zp-bottom-apply"> Apply Now </button>
            </div>
        </div>
    </div>
</template>

<script>
    import act_pay from './Act_pay'
    import zonep_form from './Zonep_form'
    export default {
        data() {
            return {
                models: [
                    { mode: 'prop',title: 'Prop-trading Model',intro: '引领自营交易从开始到顶峰的培养模式',price: 999.00,content1: 'Alpha Zone线下18课时专业培训计划',content2: 'Alpah TV线上课程专业视频指导',content3: 'Alpah Zone相应服务及活动',content4: '有机会成为自营交易员',content5: '有机会获得顶尖金融机构推荐名额',des: '自营模式是一种现代电子交易形式，公司或金融机构使用自己的资本和资产负债表在自己的账户上进行交易。公司和金融机构提供一个专业系统额资金账户，帮助交易员成长。交易员自己不需要寻找介乎或资金，有公司自己承担所有的交易收益或亏损' },
                    { mode: 'algo',title: 'Algo-trading Model',intro: '引领自营交易从开始到顶峰的培养模式',price: 999.00,content1: 'Alpha Zone线下18课时专业培训计划',content2: 'Alpah TV线上课程专业视频指导',content3: 'Alpah Zone相应服务及活动',content4: '有机会成为自营交易员',content5: '有机会获得顶尖金融机构推荐名额',des: '自营模式是一种现代电子交易形式，公司或金融机构使用自己的资本和资产负债表在自己的账户上进行交易。公司和金融机构提供一个专业系统额资金账户，帮助交易员成长。交易员自己不需要寻找介乎或资金，有公司自己承担所有的交易收益或亏损' }
                ]
            }
        },
        methods: {
            pay() {
                const self = this
                // self.form.order = 0
                // self.form.location = location
                // self.form.price = price
                self.$store.dispatch('CHANGEZONETYPE',2)
                if(!sessionStorage.getItem('token')){
                    self.$store.dispatch('TOGGLELOGIN','on')
                }else{
                    self.$store.dispatch('TOGGLEZONEPFORM','on')
                }
            }
        },
        components: {
            zonep_form,
            act_pay
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .zp-box{
        width: 100%;
        overflow: hidden;
        position: relative;
        .zp-top{
            background: url(../assets/images/act_banner.jpg) top center no-repeat;
            background-size: 100%;
            overflow: hidden;
            min-height: 1000px;
            margin-bottom: 60px;
            .zp-wrp{
                width: 1140px;
                margin:150px auto 60px;
                overflow: hidden;
                // 简介
                .zp-info{
                    width: 65%;
                    background: rgba(51,61,76,.7);
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
                // apply
                .zp-model{
                    width: 100%;
                    padding: 0;
                    margin: 0;
                    background: transparent;
                    font-size: 14px;
                    .zp-model-item{
                        padding: 50px 70px;
                        text-align: center;
                        border: 1px solid #f3f6f8;
                        width: 550px;
                        min-height: 300px;
                        background: rgba(255,255,255,.98);
                        float: left;
                        box-sizing: border-box;
                        cursor: pointer;
                        &:first-child{
                            margin-right: 40px;
                        }
                        &:hover{
                            box-shadow: 0px 50px 50px 0 rgba(0,0,0,.05);
                        }
                        // 标题
                        .zp-model-item-title{
                            color: $primary;
                            font-size: 20px;
                            font-weight: bold;
                            background: url(../assets/images/zplus_arrow.png) bottom center no-repeat;
                            background-size: 18%;
                            margin: 0;
                            padding-bottom: 20px;
                        }
                        // 介绍
                        .zp-model-item-intro{
                            margin: 0;
                            padding: 15px 0;
                            font-size: 14px;
                            color:$gray2;
                        }
                        // icon
                        .zp-model-item-icon{
                            margin: 0 auto;
                            padding: 0;
                            width: 100px;
                            height: 100px;
                            .zp-model-item-icon-img{
                                background-image: url(../assets/images/prop_icon.png);
                                background-size: 100%;
                                width: 100%;
                                height: 100%;
                                display: block;
                            }
                        }
                        // price
                        .zp-model-item-sel{
                            .zp-model-item-left,.zp-model-item-right{
                                color: #333;
                            }
                            .zp-model-item-left{
                                line-height: 30px;
                            }
                            .zp-model-item-right{
                                /*position: relative;
                                top: 10px;*/
                            }
                        }
                        // 特色
                        .zp-model-item-content{
                            margin: 0;
                            padding: 0;
                            color: $gray3;
                            padding-bottom: 15px;
                            span{
                                color: $danger;
                            }
                        }
                        // apply按钮
                        .zp-model-item-option{
                            margin: 0;
                            padding: 0;
                            .zp-model-item-apply{
                                width: 100px;
                                height: 32px;
                                font-size: 16px;    
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
                        // 按钮下的一段话
                        .zp-model-item-des{
                            margin: 0;
                            padding: 0;
                            font-size: 16px;   
                            color: $gray2;
                            padding: 15px 0;
                            line-height: 1.5;
                        }
                    }
                    .zp-model-item:last-child{
                        .zp-model-item-icon-img{
                            background-image: url(../assets/images/algo_icon.png);
                            background-size: 100%;
                            width: 100%;
                            height: 100%;
                            display: block;
                        }
                    }
                }
            }
        }
        // footer
        .zp-bottom{
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: url(../assets/images/zone_bottom.png) center center no-repeat;
            background-size: 100% 100%;
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