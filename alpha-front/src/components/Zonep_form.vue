<template>
    <div class="zpf-box">
        <div class="zpf-dialog">
            <i class="zpf-close" @click="close">
                <s class="zpf-close-line"></s>
            </i>
            <div class="zpf-header">Zone+申请</div>
            <form class="zpf-form">
                <div class="zpf-place">
                    <label for="place">
                        Place
                    </label>
                    <select disabled v-model="local" name="place" id="">
                        <option v-for="item in places" :value="item.value">
                            {{item.text}}
                        </option>
                    </select>
                </div>
                <div class="zpf-date">
                    <label for="date">
                        Start Date
                    </label>
                    <date-picker class="zpf-date-input" :date="startTime" :option="option" :limit="limit"></date-picker>
                </div>
                <div class="zpf-period">
                    <label for="period">
                        Period
                    </label>
                    <select disabled id="period" v-model="period">
						<option disabled="true">Period</option>
						<option v-for="item in periods" :value="item.value">{{item.text}}</option>
					</select>
                </div>
                <div class="zpf-type">
                    <label for="type">
                        Model
                    </label>
                    <select id="type" v-model="model" @change="cModel">
						<option disabled="true">Model</option>
						<option v-for="item in models" :value="item.value">{{item.text}}</option>
					</select>
                </div>
                <div class="zpf-name">
                    <label for="name">
                        FirstName
                    </label>
                    <input id="name" v-model="first_name" type="text" placeholder="Example: John">
                </div>
                <div class="zpf-phone">
                    <label for="phone">
                        Phone
                    </label>
                    <input id="phone" v-model="phone" type="text" placeholder="Example: 18988889999">
                </div>
                <div class="zpf-email">
                    <label for="email">
                        E-mail
                    </label>
                    <input id="email" v-model="email" type="text" placeholder="Example: alpha@gmail.com">
                </div>
                <div class="zpf-address">
                    <label for="address">
                        Company
                    </label>
                    <input id='address' v-model="addr" type="text" placeholder="Example: Alpha co">
                </div>
                <div class="zpf-position">
                    <label for="position">
                        交易平台
                    </label>
                    <input id='position' type="text" placeholder="若无则可不填">
                </div>
                
                <div class="zpf-cost">
                    <label for="cost">
                        Fee
                    </label>
                    <span>
                        ￡{{price}}
                    </span>
                </div>
                <div class="zpf-btns">
                    <button @click="openPay" class="zpf-submit btn-primary" type="button">
                        Next
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</template>

<script>
    import Datepicker from 'vue-datepicker'
    export default {
        data() {
            return {
                local: 1,
                price: 0.00,
                first_name: '',
                phone: '',
                period: '',
                email: '',
                addr: '',
                model: '',
                price: 0,
                places: [
                    { text: 'Lodon', value: 1 },
                    { text: 'Shanghai', value: 2 },
                    { text: 'Manchester', value: 3 },
                    { text: 'Chengdu', value: 4 }
                ],
                periods: [
					{ value: '1', text: 'one month' },
					{ value: '2', text: 'two month' },
					{ value: '3', text: 'three month' },
					{ value: '4', text: 'four month' },
					{ value: '5', text: 'five month' },
					{ value: '6', text: 'six month' }
				],
                models: [
					{ value: '1', text: 'prop普通' },
					{ value: '2', text: 'prop高级' },
					{ value: '3', text: 'algo普通' },
					{ value: '4', text: 'algo高级' }
				],
                // for Vue 2.0 
				startTime: {
					time: ''
				},
				endtime: {
					time: ''
				},
				option: {
					type: 'day',
					week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
					month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
					format: 'YYYY-MM-DD',
					placeholder: 'Start Date',
					inputStyle: {
                    'width': '100%',
					'display': 'inline-block',
					'padding': '0px 10px',
					'height': '40px',
					'box-sizing': 'border-box',
					'line-height': '40px',
					'font-size': '14px',
					'border': '2px solid #fff',
					'margin-right': '20px',
					'overflow': 'hidden',
					'box-shadow': '0 1px 3px 0 rgba(0, 0, 0, 0.2)'
					},
					color: {
					header: '#666',
					headerText: '#fff'
					},
					buttons: {
					ok: 'Ok',
					cancel: 'Cancel'
					},
					overlayOpacity: 0.5, // 0.5 as default 
					dismissible: true // as true as default 
				},
				timeoption: {
					type: 'min',
					week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
					month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
					format: 'YYYY-MM-DD HH:mm'
				},
				multiOption: {
					type: 'multi-day',
					week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
					month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
					format:"YYYY-MM-DD HH:mm"
				},
				limit: [{
					type: 'weekday',
					available: [1, 2, 3, 4, 5]
				},
				{
					type: 'fromto',
					from: '2016-02-01',
					to: '2016-02-20'
				}]
            }
        },
        mounted() {
            const self = this
            self.local = self.$store.state.zone_forms.location
            self.$store.state.zone_type == 1 && ( show_model = true )
            let formData = new FormData()
			formData.append('token',sessionStorage.getItem('token'))
            fetch(self.$store.state.api_addr + 'user/user_info_center',{
                method: 'post',
                mode: 'cors',
                body: formData
            }).then((res) => {
                res.ok && res.json().then((json) => {
                    self.email = json.data.email
                    self.phone = json.data.phone
                    self.first_name = json.data.first_name
                    self.position = json.data.pro
                    self.addr = json.data.organization
                })
            })
        },
        methods: {
            cModel() {
                const self = this
                let model = self.model
                if(model == 1) {
                    self.local = 3
                    self.period = 3
                    self.price = 0.01
                    self.$store.dispatch('CHANGEZPPAY',0.01/self.period)
                }else if(model == 2) {
                    self.local = 3
                    self.price = 0.02
                    self.period = 3
                    self.$store.dispatch('CHANGEZPPAY',0.02/self.period)
                }else if(model == 3) {
                    self.local = 3
                    self.price = 0.01
                    self.period = 3
                    self.$store.dispatch('CHANGEZPPAY',0.01/self.period)
                }else{
                    self.local = 3
                    self.price = 0.02
                    self.period = 3
                    self.$store.dispatch('CHANGEZPPAY',0.02/self.period)
                }
            },
            close() {
				let self = this
				self.$store.dispatch('TOGGLEZONEPFORM','off')
			},
            openPay() {
                let self = this
                let formData = new FormData()
                self.$store.dispatch('CHANGEZPPAY',self.$store.state.pay_info.price*self.period)
                self.$store.dispatch('TOGGLEACTPAY','on')
                self.$store.dispatch('TOGGLEZPFORM','off')
                formData.append('token',sessionStorage.getItem('token'))
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
                        json.archive.status === 0 && self.$store.dispatch('TOGGLEACTPAY','on');self.$store.dispatch('TOGGLEZONEPFORM','off')
                    })
                })
            }
        },
        components: {
            'date-picker': Datepicker
        }
    }
</script>

<style scoped lang="scss">
    @import '../css/alpha.scss';

    $zpfheight: 36px;

    .zpf-box{
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(1,1,1,.5);
        z-index: 999;
        .zpf-dialog{
            position: relative;
            width: 600px;
            margin: 100px auto;
            background: #fff;
            box-shadow: 0 0 18px rgba(0,0,0,.01);
            border-radius: 8px;
            top:35px;
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
				&:hover{
					color: $gray3;
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
                .zpf-header-icon{
                    display: block;
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    background-image: url(../assets/images/act_form_icon.png);
                    background-size: 40px;
                    background-position: center center;
                    background-repeat: no-repeat;
                }
            }
            .zpf-form{
                padding: 0 70px 30px;
                .zpf-place,.zpf-date,.zpf-period,.zpf-type,.zpf-name,.zpf-phone,.zpf-email,.zpf-address,.zpf-position,.zpf-combo,.zpf-cost{
                    padding-bottom: 20px;
                    overflow: hidden;
                    label{
                        width: 20%;
                        color: $gray1;
                        font-size: 14px;
                        font-weight: 600;
                        box-sizing: border-box;
                        padding-right: 10px;
                        line-height: $zpfheight;
                        text-align: right;
                        float: left;
                        overflow: hidden;
                    }
                    input,select{
                        width: 70%;
                        border: 1px solid $gray5;
                        border-radius: 3px;
                        padding-left: 10px;
                        box-sizing: border-box;
                        height: $zpfheight;
                        line-height: $zpfheight;
                        outline: none;
                        float: left;
                        background-color:#fff; 
                    }
                    span{
                        float: left;
                        line-height: $zpfheight;
                        width: 50%;
                        color: $danger;
                        font-weight: 900;
                    }
                    .zpf-date-input{
                        width: 70%;
                        .cov-datepicker{
                            width: 100% !important;
                            box-sizing: border-box;
                            padding-left: 10px;
                        }
                    }
                }
                .zpf-cost{
                    padding: 0;
                }
                .zpf-btns{
                    width: 100%;
                    padding-top: 30px;
                    .zpf-submit{
                        margin: 0 auto;
                        display: block;
                        position: relative;
                    }
                }
                
            }
        }
    }
</style>