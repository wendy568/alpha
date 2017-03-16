<template>
    <div class="ad-mask">
        <div class="ad-box">
            <act-form v-if="$store.state.show_actform"></act-form>
            <act-pay v-if="$store.state.show_actpay"></act-pay>
            <!-- 活动图 -->
            <div class="ad-banner">
                <!-- 图片 -->
                <img class="ad-banner-img" src="../assets/images/235422423983351494.png" alt="">
                <!-- 状态 -->
                <div class="ad-banner-mask">
                    <span class="ad-status">{{detail.status}}</span>
                </div>
                <!-- 遮罩 -->
                <div class="shade">
                    <span>6 DAYS 13 HOURS 48 MIN</span>
                    <button class="ad-banner-submit" @click="openEnroll"> Apply Now </button>
                </div>
            </div>
            <!-- 活动内容 -->
            <div class="ad-content">
                <!-- title -->
                <h3 class="ad-title">{{detail.name}}</h3>
                <!-- 活动描述 -->
                <p class="ad-des"> description:{{detail.desribe}}</p>
                <!-- 时间 -->
                <p class="ad-time"> {{detail.start}} 至 {{detail.end}}</p>
                <!-- 地点 -->
                <p class="ad-place">
                    <i class="ad-place-icon"></i>
                    {{detail.place}}
                </p>
                <!-- 活动详情 -->
                <div class="ad-detail">
                    <!-- title -->
                    <p class="ad-detail-title"> Activity Detail</p>
                    <!-- 内容 -->
                    <p class="ad-detail-content"> {{detail.desribe}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                detail: {
                    name: '',
                    desribe: '',
                    start: '2016-10-23',
                    end: '2016-10-24',
                    price: 0.00,
                    place: 'SOSO shanghai floor 1',
                    intro: 'text text text text text text,text text text text text text,text text text text text text,text text text text text text,text text text text text text,text text text text text text',
                    status: '报名中'                
                }
            }
        },
        mounted() {
            const self = this
            let formData = new FormData()
            formData.append('id',self.$store.state.act_id)
            fetch(self.$store.state.api_addr + 'activity/Activity_detail',{
                mode: 'cors',
                method: 'post',
                body: formData
            }).then((res) => {
                if(res.ok){
                    res.json().then((json) => {
                        json.archive.status === 0 && ( self.detail = json.data )
                    })
                }
            })
        },
        methods: {
            close() {
				let self = this
				self.$store.dispatch('TOGGLEACTDETAIL','off')
			},
            openEnroll(id,price) {
                let self = this
                self.$store.dispatch('TOGGLEACTFORM','on')
                self.$store.dispatch('TOGGLEACTDETAIL','off')
            }
        },
        components: {
            'act-form' (resolve) {
                require(['./Act_form'], resolve)
            },
            'act-pay' (resolve) {
                require(['./Act_pay'], resolve)
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .ad-mask{
        width: 100%;
        overflow: hidden;
        background: #f3f6f8;
        position: relative;
        .ad-box{
            width: 960px;
            overflow: hidden;
            margin: 30px auto ;
            background: #fff;
            .ad-close{
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
				.ad-close-line{
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
            .ad-banner{
                width: 100%;
                height: 540px;
                position: relative;
                .ad-banner-img{
                    width: 100%;
                    height: 100%;
                }
                .ad-status{
                    position: absolute;
                    left: 20px;
                    top: 20px;
                    width: 80px;
                    height: 30px;
                    font-size: 14px;
                    background: $success;
                    color: #fff;
                    border-radius: 2px;
                    line-height: 30px;
                    text-align: center;
                }
                .shade{
                    width: 100%;
                    height: 50px;
                    background-color: rgba(0,0,0,.5);
                    position: absolute;
                    top:490px;
                    line-height: 50px;
                    span{
                        font-size: 16px;
                        color:#fff;
                        margin-left: 40px;
                        float: left;
                    }
                    .ad-banner-submit{
                        float: right;
                        width: 120px;
                        height: 50px;
                        text-align: center;
                        background: $primary;
                        color: #fff;
                        font-size: 16px;
                        outline: none;
                        border: none;
                        cursor: pointer;
                    }
                }
            }
            .ad-content{
                width: 100%;
                box-sizing: border-box;
                padding: 20px 40px;
                .ad-title{
                    color: $gray1;
                    font-size: 24px;
                    font-weight: bold;
                    margin: 0;
                }
                .ad-des{
                    margin: 0;
                    margin: 20px 0;
                    color: $gray2;
                    font-size: 14px;
                }
                .ad-time{
                    margin: 0;
                    padding: 10px 0;
                    color: $gray2;
                    font-size: 14px;
                }
                .ad-place{
                    margin: 0;
                    padding: 10px 0;
                    color: $gray2;
                    font-size: 14px;
                    .ad-place-icon{
                        
                    }
                }
                .ad-detail{
                    width: 100%;
                    .ad-detail-title{
                        margin: 0;
                        padding-top: 10px;
                        color: $gray1;
                        font-weight: bold;
                        font-size: 16px;
                    }
                    .ad-detail-content{
                        margin: 0;
                        padding: 10px 0;
                        color: $gray1;
                        font-size: 16px;
                        line-height: 2;
                    }
                }
            }
        }
    }
</style>