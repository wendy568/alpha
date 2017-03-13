<template>
    <div class="ad-box">
        <div class="ad-dialog">

            <i class="ad-close" @click="close">
				<s class="ad-close-line"></s>
			</i>

            <div class="ad-banner">
                <img class="ad-banner-img" src="" alt="">
                <div class="ad-banner-mask">
                    <span class="ad-status">
                        {{detail.status}}
                    </span>
                </div>
                <button class="ad-banner-submit" @click="openEnroll">
                    Apply Now
                </button>
            </div>
            <div class="ad-content">
                <h3 class="ad-title">
                    {{detail.name}}
                </h3>
                <p class="ad-des">
                    description:{{detail.desribe}}
                </p>
                <p class="ad-time">
                    {{detail.start}} 至 {{detail.end}}
                </p>
                <p class="ad-place">
                    <i class="ad-place-icon"></i>
                    {{detail.place}}
                </p>
                <div class="ad-detail">
                    <p class="ad-detail-title">
                        Activity Detail
                    </p>
                    <p class="ad-detail-content">
                        {{detail.desribe}}
                    </p>
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
            openEnroll() {
                let self = this
                self.$store.dispatch('TOGGLEACTFORM','on')
                self.$store.dispatch('TOGGLEACTDETAIL','off')
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .ad-box{
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(230,240,250,.7);
        z-index: 999;
        .ad-dialog{
            position: relative;
            width: 900px;
            margin: 100px auto;
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
                height: 400px;
                position: relative;
                .ad-banner-img{
                    width: 100%;
                    height: 100%;
                }
                .ad-banner-mask{
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    left: 0;
                    top: 0;
                    background: rgba(0,0,0,.18);
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
                }
                .ad-banner-submit{
                    position: absolute;
                    right: 30px;
                    bottom: -18px;
                    width: 100px;
                    height: 36px;
                    text-align: center;
                    line-height: 36px;
                    border-radius: 18px;
                    background: $primary;
                    color: #fff;
                    font-size: 14px;
                    outline: none;
                    border: none;
                    cursor: pointer;
                }
            }
            .ad-content{
                width: 100%;
                box-sizing: border-box;
                padding: 30px 40px;
                .ad-title{
                    color: $gray1;
                    font-size: 24px;
                    font-weight: bold;
                    padding-bottom: 10px;
                    margin: 0;
                }
                .ad-des{
                    margin: 0;
                    padding: 10px 0;
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