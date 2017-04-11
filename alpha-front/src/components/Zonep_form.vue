<template>
    <div class="zpf-box">
        <div class="model" @click="close"> </div>
        <div class="zpf-dialog">
            <i class="zpf-close" @click="close">
                <s class="zpf-close-line"></s>
            </i>
            <div class="zpf-header">Zone+申请</div>

            <!-- 表单 -->
            <form class="zpf-form">
                <!-- 选择套餐 -->
                <div class="sale-type">
                    <label for="name" class="title"> Zone+类型 </label>
                    <div  class="choose"  @click="cModel($event)" :class="{'active':show_one}">
                        <i class="icon"></i>
                        <span class="text" id="Lodon">Prop-Trading普通</span>
                        <input class="btn-default-out" type="button" >
                    </div>
                    <div  class="choose"  @click="cModel($event)" :class="{'active':show_two}">
                        <i class="icon"></i>
                        <span class="text" id="Shanghai">Prop-Trading高级</span>
                        <input class="btn-default-out" type="button" >
                    </div>
                    <div  class="choose"   @click="cModel($event)" :class="{'active':show_three}">
                        <i class="icon"></i>
                        <span class="text" id="Manchester">Algo-Trading普通</span>
                        <input class="btn-default-out" type="button" >
                    </div>
                    <div  class="choose"   @click="cModel($event)" :class="{'active':show_four}">
                        <i class="icon"></i>
                        <span class="text" id="Chengdu">Algo-Trading高级</span>
                        <input class="btn-default-out" type="button" >
                    </div>
                </div>
                <div class="info">
                    <label for="name" class="title"> Name </label>
                    <input id="name" class="content" v-model="first_name" type="text" placeholder="Example: John">
                </div>
                <div class="info">
                    <label for="phone" class="title">Phone</label>
                    <input id="phone" class="content" v-model="phone" type="text" placeholder="Example: 18988889999">
                </div>
                <div class="info">
                    <label for="email" class="title"> E-mail</label>
                    <input id="email" class="content" v-model="email" type="text" placeholder="Example: alpha@gmail.com">
                </div>
                <div class="info">
                    <label for="position" class="title">交易平台</label>
                    <input id='position' class="content" type="text" v-model="tradingplatform" placeholder="若无则可不填">
                </div>
                <div class="info">
                    <label for="cost" class="title">Package Fee</label>
                    <span class="price">￡{{price}} </span>
                </div>
            </form>
            <!-- 默认选择的地址 -->
            <div class="adr"  >
                <!-- 地点 -->
                <div class="row" >
                    <label class="title">地点:</label>
                    <input class="content" disabled="disabled" v-model="location">
                </div>
                <!-- 开始日期 -->
                <div class="row">
                    <label class="title">开始日期:</label>
                    <input class="content" disabled="disabled" v-model="start">
                </div>
                <!-- 周期 -->
                <div class="row" >
                    <label class="title">周期:</label>
                    <input class="content" disabled="disabled" v-model="period">
                </div>
            </div> 
            <!-- next -->
            <div class="zpf-btns">
                <button @click="openPay" class="zpf-submit" type="button">Next </button>
            </div> 
        </div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                model: '',
                first_name: '',
                phone: '',
                email: '',
                price: 0.01,
                tradingplatform:'',
                location:'',
                location_num:'',
                start:'',
                period:'',
                period_num:'',
                show_one:true,
                show_two:false,
                show_three:false,
                show_four:false,
                startTime:'2017-6-30',
                zonep_type:''
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
                    self.first_name = json.data.first_name
                    self.phone = json.data.phone
                    self.email = json.data.email
                    self.position = json.data.pro
                    self.tradingplatform = json.data.tradingplatform
                })
            })
            self.start='2017-6-30'
            self.price=0.01
            self.location_num=1
            self.period_num=1
            self.zonep_type='1:1'
            if(self.$store.state.zoneplus_forms.location==1){
                self.location='Lodon'
                self.period='one month'
            }else if(self.$store.state.zoneplus_forms.location==2){
                self.location='Shanghai'
                self.period='two month'
            }else if(self.$store.state.zoneplus_forms.location==3){
                self.location='Manchester'
                self.period='three month'
            }else{
                self.location='Chengdu'
                self.period='four month'
            }
            
        },
        methods: {
            cModel(e) {
                const self = this
                const target = e.target
                self.start='2017-6-30'
                self.location=target.id
                console.log(self.location)
                if(target.id == 'Lodon'){
                    self.show_one=true
                    self.show_two=false
                    self.show_three=false
                    self.show_four=false
                    self.period='one month' 
                    self.price=0.01
                    self.location_num=1
                    self.period_num=1
                    self.zonep_type='1:1'
                    self.$store.dispatch('CHANGEZONEPPAY',0.01)
                }else if(target.id == 'Shanghai'){
                    self.show_one=false
                    self.show_two=true
                    self.show_three=false
                    self.show_four=false
                    self.period='two month' 
                    self.price=0.02
                    self.location_num=2
                    self.period_num=2
                    self.zonep_type='1:2'
                    self.$store.dispatch('CHANGEZONEPPAY',0.02)
                }else if(target.id == 'Manchester'){
                    self.show_one=false
                    self.show_two=false
                    self.show_three=true
                    self.show_four=false
                    self.period='three month' 
                    self.price=0.01
                    self.location_num=3
                    self.period_num=3
                    self.zonep_type='2:1'
                    self.$store.dispatch('CHANGEZONEPPAY',0.01)
                }else {
                    self.show_one=false
                    self.show_two=false
                    self.show_three=false
                    self.show_four=true
                    self.period='four month' 
                    self.price=0.02
                    self.location_num=4
                    self.period_num=4
                    self.zonep_type='2:2'
                    self.$store.dispatch('CHANGEZONEPPAY',0.02)
                }
            },
            close() {
				let self = this
				self.$store.dispatch('TOGGLEZONEPFORM','off')
			},
            openPay() {
                let self = this
                let formData = new FormData()
                self.$store.dispatch('CHANGEZONEPPAY',self.$store.state.pay_info.price)
                self.$store.dispatch('TOGGLEACTPAY','on')
                self.$store.dispatch('TOGGLEZONEPFORM','off')
                formData.append('token',sessionStorage.getItem('token'))
                console.log(sessionStorage.getItem('token'))
                formData.append('first_name',self.first_name)
			    formData.append('phone',self.phone)
			    formData.append('pro',self.position)
			    formData.append('organization',self.addr)
                self.$store.dispatch('CHANGEPAYTABLE','zone_plus_order')
                fetch(self.$store.state.api_addr + 'user/update_user_info',{
                    method: 'post',
                    mode: 'cors',
                    body: formData
                }).then((res) => {
                    res.ok && res.json().then((json) => {
                        switch(json.archive.status){
                            case 0:
                                let formData = new FormData()
                                formData.append('location',self.location_num)
                                console.log(self.location_num)
                                formData.append('start',self.startTime)
                                console.log(self.startTime)
                                formData.append('limit',self.period_num)
                                console.log(self.period_num)
                                formData.append('zonep_type',self.zonep_type)
                                console.log(self.zonep_type)
                                fetch(self.$store.state.api_addr + 'ZoneAndPlus/made_zone_info',{
                                    method: 'post',
                                    mode: 'cors',
                                    body: formData
                                }).then((res) => {
                                    self.$store.dispatch('TOGGLEACTPAY','on')
                                    self.$store.dispatch('TOGGLEZPFORM','off')
                                })
                                break;
                        }
                    })
                })
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';

    $zpfheight: 36px;

    .zpf-box{
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(1,1,1,.5);
        z-index: 999;
        overflow: scroll;
        .model{
            position: absolute;
            width: 100%;
            height: 100%;
            z-index:100;
        }
        .zpf-dialog{
            position: relative;
            margin:120px auto;
            width: 600px;
            background: #fff;
            box-shadow: 0 0 18px rgba(0,0,0,.01);
            border-radius: 8px;
            z-index: 2000;
            .zpf-close{
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
				.zpf-close-line{
					width: 2px;
					height: 20px;
					position: absolute;
					bottom: -20px;
					left: 50%;
					margin-left: -1px;
					background-color: #fff;
				}
			}
            .zpf-header{
               width: 100%;
                overflow: hidden;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                line-height: 100px;
                color:$gray1;
            }
            .zpf-form{
                padding: 0 60px 10px;
                .info{
                    padding-bottom: 10px;
                    overflow: hidden;
                    font-size: 14px;
                    .title{
                        width: 21%;
                        color: $gray1;
                        font-weight:bold;
                        box-sizing: border-box;
                        padding-right: 10px;
                        line-height: $zpfheight;
                        text-align: right;
                        float: left;
                        overflow: hidden;
                    }
                    .content{
                        width: 70%;
                        border: 1px solid $gray5;
                        border-radius: 3px;
                        padding-left: 10px;
                        box-sizing: border-box;
                        line-height: $zpfheight;
                        color:$gray2;
                        outline: none;
                        float: left;
                    }
                    .price{
                        float: left;
                        line-height: $zpfheight;
                        width: 50%;
                        color: $danger;
                        font-weight: 900;
                    }
                    
                }
                .sale-type{
                    padding-bottom: 20px;
                    overflow: hidden;
                    font-size: 14px;
                    .title{
                        width: 21%;
                        color: $gray1;
                        font-weight:bold;
                        box-sizing: border-box;
                        padding-right: 10px;
                        line-height: 80px;
                        text-align: right;
                        float: left;
                        overflow: hidden;
                    }
                    .choose{
                        float: left;
                        width: 160px;
                        margin-right: 10px;
                        height: 40px;
                        margin-top: 5px;
                        z-index:1000;
                        .btn-default-out{
                            width: 160px;
                            height: 40px;
                            float: left;
                            z-index:1;
                            border-radius: 7px;
                            position: relative;
                            border:1px solid $gray5;
                        }
                        .text{
                            width: 100%;
                            position: absolute;
                            line-height: 38px;
                            padding-left: 23px;
                            z-index: 800;
                            cursor: pointer;
                            float: left;
                        }
                        .icon{
                            width: 21px;
                            height: 18px;
                            float: left;
                            margin-left: 138px;
                            margin-top: 1px;
                            position: absolute;
                            background:url(../assets/images/alert_zoneplus_selected.png) no-repeat;
                            background-size: 100% 100%;
                            transition: all .2s;
                            z-index:500; 
                            display: none;
                        }
                        &.active{
                            .icon{
                                display: block;
                            }
                            .btn-default-out{
                                background-color: $success;
                            }
                            .text{
                                color:#fff;
                            }
                        } 
                    }
                }
                .zpf-cost{
                    padding: 0;
                }
            }
            .adr{
                width: 100%;
                overflow: hidden;
                background:#fcfbf9;
                .row{
                     width: 100%;
                     height: 40px;
                     color:$primary;
                     .title{
                        width: 27%;
                        font-weight:bold;
                        box-sizing: border-box;
                        padding-right: 10px;
                        line-height: 40px;
                        text-align: right;
                        float: left;
                        overflow: hidden;
                    }
                    .content{
                        width: 70%;
                        padding-left: 10px;
                        box-sizing: border-box;
                        line-height: $zpfheight;
                        outline: none;
                        float: left;
                        border:none;
                        cursor: default;
                        background:#fcfbf9;
                        color:$primary;
                    }
                }
            }
            .zpf-btns{
                width: 100%;
                padding: 20px 0 40px;
                .zpf-submit{
                    outline: none;
                    border: none;
                    margin: 0 auto;
                    display: block;
                    background: $primary;
                    color: #fff;
                    width: 100px;
                    height: 36px;
                    line-height: 36px;
                    text-align: center;
                    font-size: 14px;
                    cursor: pointer;
                    border-radius: 4px;
                }
            }
        }
    }
</style>