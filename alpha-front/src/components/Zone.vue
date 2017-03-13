<template>
    <div class="zone-box">
        <zp_form v-if="$store.state.show_zpform"></zp_form>
		<act_pay v-if="$store.state.show_actpay"></act_pay>
        <div class="zone-info">
            <p class="zone-info-content">
                <b class="zone-info-content-one">
                    A
                </b>
                lpha Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,Zone is a professoional room invested by Alphatrader,
            </p>
        </div>
        <ul class="zone-list">
            <li class="zone-item" v-for="item in zone_list">
                <div class="zone-item-img-box">
                    <img class="zone-item-img" :src="item.image" alt="">
                    <div class="zone-item-mask">
                        <span class="zone-item-status-on">
                            {{item.status | show_status}}
                        </span>
                    </div>
                </div>
                <div class="zone-item-info">
                    <h3 class="zone-item-title">
                        {{item.title}}
                    </h3>
                    <p class="zone-item-place">
                        location:{{item.location | location}}
                    </p>
                    <p class="zone-item-count">
                        count:{{item.num}}
                    </p>
                    <button @click="pay(item.id,item.price,item.location)" class="zone-item-apply" :class="{ 'zone-item-apply-off': item.status === '暂未开放' }">
                        Apply
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import zp_form from './Zp_form'
    import act_pay from './Act_pay'
    export default {
        data() {
            return {
                zone_list: [
                    // { title: 'vue2.0 yufa bianhua',img: '',status: '租赁中',place: 'OXFORD RD.MANCHESTER M13 9PL',count: 20 },
                    // { title: 'vue2.0 yufa bianhua',img: '',status: '租赁中',place: 'OXFORD RD.MANCHESTER M13 9PL',count: 20 },
                    // { title: 'vue2.0 yufa bianhua',img: '',status: '暂未开放',place: 'OXFORD RD.MANCHESTER M13 9PL',count: 20 },
                    // { title: 'vue2.0 yufa bianhua',img: '',status: '租赁中',place: 'OXFORD RD.MANCHESTER M13 9PL',count: 20 }
                ]
            }
        },
        methods: {
            pay(id,price,location) {
				const self = this
                // self.form.order = 0
                // self.form.location = location
                // self.form.price = price
                self.$store.dispatch('CHANGEZONEINFO',location)
				if(sessionStorage.getItem('token')){
					self.$store.dispatch('CHANGEPAYINFO',price)
					self.$store.dispatch('CHANGEZPID',id)
                    self.$store.dispatch('TOGGLEZPFORM','on')
				}else{
					self.$store.dispatch('TOGGLETIP',self.$store.state.tip.login)
				}
			}
        },
        filters: {
            location(status) {
                if(status == 1) {
                    return 'Lodon'
                }else if(status == 2){
                    return 'Shanghai'
                }else if(status == 3){
                    return 'Manchester'
                }else{
                    return 'Chengdu'
                }
            },
            show_status(status) {
                if(status == 0) {
                    return 'Full'
                }else if(status == 1){
                    return 'Opening'
                }else{
                    return 'Open soon'
                }
            }
        },
        mounted() {
            const self = this
            let formData = new FormData()
            formData.append('start',0)
            formData.append('limit',4)
            fetch(self.$store.state.api_addr + 'ZoneAndPlus/zone_list',{
                method: 'post',
                mode: 'cors',
                body: formData
            }).then((res) => {
                res.ok && res.json().then((json) => {
                    json.archive.status === 0 && ( self.zone_list = json.data )
                    for(let i = 0;i < self.zone_list.length;i ++ ) {
                        if(self.zone_list[i].location == 1) {
                            self.zone_list[i].title = 'Lodon Zone'
                        }else if(self.zone_list[i].location == 2) {
                            self.zone_list[i].title = 'Shanghai Zone'
                        }else if(self.zone_list[i].location == 3) {
                            self.zone_list[i].title = 'Manchester Zone'
                        }else{
                            self.zone_list[i].title = 'Chengdu Zone'
                        }
                    }
                    for(let y = 0;y < self.zone_list.length;y ++){
                        if(self.zone_list[y].image !== null || self.zone_list[y].image !== "" || self.zone_list[y].image !== undefined){
                            self.zone_list[y].image = self.$store.state.api_addr + 'upload/' + self.zone_list[y].image[0] + 'm_' + self.zone_list[y].image[1]    
                        }else{
                            self.zone_list[y].image = 'http://content.jwplatform.com/thumbs/' + self.zone_list[y].source + '-320.jpg' 
                        }
                    }   
                })
            })
        },
        components: {
            zp_form,
            act_pay
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';
    .zone-box{
        position: relative;
        width: 100%;
        overflow: hidden;
        .zone-info{
            width: 1140px;
            margin: 0 auto;
            padding: 30px 0;
            .zone-info-content{
                color: $gray2;
                margin: 0;
                font-size: 16px;
                .zone-info-content-one{
                    font-size: 40px;
                    font-weight: 400;
                    padding: 0;
                    margin: 0;
                    color: $gray2;
                }
            }
        }
        .zone-list{
            padding: 0;
            margin: 0 auto;
            width: 1140px;
            .zone-item{
                width: 50%;
                float: left;
                overflow: hidden;
                padding-bottom: 40px;
                box-sizing: border-box;
                &:nth-child(2n-1){
                    padding-right: 40px;
                }
                &:nth-child(2n){
                    padding-left: 40px;
                }
                .zone-item-img-box{
                    width: 100%;
                    height: 400px;
                    position: relative;
                    .zone-item-img{
                        width: 100%;
                        height: 100%;
                    }
                    .zone-item-mask{
                        width: 100%;
                        height: 320px;
                        position: absolute;
                        left: 0;
                        top: 0;
                        background: rgba(0,0,0,.18);
                        .zone-item-status-on,.zone-item-status-off{
                            position: absolute;
                            left: 10px;
                            top: 10px;
                            width: 80px;
                            height: 30px;
                            color: #fff;
                            text-align: center;
                            border-radius: 1px;
                            outline: none;
                            border: none;
                            line-height: 30px;
                            font-size: 14px;
                        }
                        .zone-item-status-on{
                            background: $info;
                        }
                        .zone-item-status-off{
                            background: rgba(0,0,0,.5);
                        }
                    }
                }
                .zone-item-info{
                    width: 100%;
                    overflow: hidden;
                    position: relative;
                    .zone-item-title{
                        font-size: 20px;
                        color: $gray1;
                        font-weight: bold;
                        padding: 20px 0 15px 0;
                        margin: 0;
                    }
                    .zone-item-place{
                        padding: 0 0 15px 0;
                        margin: 0;
                        font-size: 14px;
                        color: $gray2;
                    }
                    .zone-item-count{
                        padding: 0;
                        margin: 0;
                        font-size: 14px;
                        color: $gray2;
                    }
                    .zone-item-apply{
                        position: absolute;
                        right: 0;
                        bottom: 0;
                        width: 80px;
                        height: 32px;
                        border-radius: 1px;
                        background: $primary;
                        color: #fff;
                        outline: none;
                        border: none;
                        font-size: 14px;
                        cursor: pointer;
                    }
                    .zone-item-apply-off{
                        background: rgba(0,0,0,.5);
                        cursor: default;
                    }
                }
            }
        }
    }
</style>