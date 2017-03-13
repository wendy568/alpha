import Vue from 'vue'
import Vuex from 'vuex'

const debug = process.env.NODE_ENV !== 'production'
Vue.use(Vuex)
Vue.config.debug = debug

const state = {
	api_addr: 'http://120.25.211.159/ww_edu/',
	is_online: false,
	show_login: false,
	show_register: false,
	show_actdetail: false,
	show_actform: false,
	show_actpay: false,
	// show_alipay: false,
	show_zpform: false,
	show_zonepform: false,
	zone_forms: {
		location: '',
		price: ''
	},
	pay_table: 'event_order',
	zone_type: '',
	pay_info: {
		price: 0.01,
		name: '',
		total: ''
	},
	tip: {
		show: false,
		text: '',
		login: 'Please log in again'
	},
	act_id: 0,
	zp_id: 0,
	user_email: sessionStorage.getItem('user_email') ? sessionStorage.getItem('user_email') : '',
	pay_types: [
		{
			"icon": "../assets/images/alipay.png",
			"name": "支付宝",
			"status": true
		},
		{
			"icon": "../assets/images/paypal.png",
			"name": "Paypal",
			"status": false
		},
		{
			"icon": "../assets/images/visa.png",
			"name": "DD转账",
			"status": false
		}
	],
	user_face: sessionStorage.getItem('user_face') == 'undefined' ? '../assets/images/portrait.jpg' : sessionStorage.getItem('user_face'),
	nic_name: sessionStorage.getItem('nic_name') ? sessionStorage.getItem('nic_name') : 'visitor'
}

const mutations = {
	TOGGLETIP (state,value) {
		state.tip.show = !state.tip.show
		value && ( state.tip.text = value )
	},
	CHANGEZONEINFO (state,value) {
		state.zone_forms.location = value
	},
	CHANGEZONETYPE (state,value) {
		state.zone_type = value
	},
	CHANGEPAYINFO (state,value) {
		state.pay_info = {
			price: value
		}
	},
	// TOGGLEALIPAY (state,value) {
	// 	if(value == 'on') {
	// 		state.show_alipay = true
	// 	}else if(value == 'off') {
	// 		state.show_alipay = false
	// 	}else {
	// 		state.show_alipay = !state.show_alipay
	// 	}
	// 	console.log(state.show_alipay)
	// },
	STORAGEUSERINFO (state,user) {
		state.nic_name = user.nic_name
		state.user_email = user.email
		state.user_face = user.face
		sessionStorage.setItem('nic_name',state.nic_name)
		sessionStorage.setItem('user_email',state.user_email)
		sessionStorage.setItem('user_face',state.user_face)
	},
	CHANGEPAYTABLE (state,value) {
		state.pay_table = value
	},
	UNLOADUSERINFO (state) {
		state.nic_name = ''
		state.user_email = ''
		state.user_face = ''
		sessionStorage.removeItem('nic_name')
		sessionStorage.removeItem('user_email')
		sessionStorage.removeItem('user_face')
	},
	TOGGLEONLINE (state,value) {
		if(value == "on"){
			state.is_online = true
		}else if(value == "off"){
			state.is_online = false
		}else{
			state.is_online = !state.is_online
		}
	},
	TOGGLELOGIN (state,value) {
		if(value === 'on'){
			state.show_login = true
			state.show_register = false
		}else if(value === 'off'){
			state.show_login = false
		}else{
			state.show_login = !state.show_login
			state.show_register = false
		}
	},
	TOGGLEREGISTER (state,value) {
		if(value === 'on'){
			state.show_register = true
			state.show_login = false
		}else if(value === 'off'){
			state.show_register = false
		}else{
			state.show_login = false
			state.show_register = true
		}
	},
	CHANGEACTID (state,id) {
		state.act_id = id
	},
	CHANGEZPID (state,id) {
		state.zp_id = id
	},
	CHANGEZPPAY (state,price) {
		state.pay_info.price = price
	},
	TOGGLEACTDETAIL (state,value) {
		if(value === 'on'){
			state.show_actdetail = true
		}else if(value === 'off'){
			state.show_actdetail = false
		}else{
			state.show_actdetail = !state.show_actdetail
		}
	},
	TOGGLEACTFORM (state,value) {
		if(value === 'on'){
			state.show_actform = true
		}else if(value === 'off'){
			state.show_actform = false
		}else{
			state.show_actform = !state.show_actform	
		}
	},
	TOGGLEZPFORM (state,value) {
		if(value === 'on'){
			state.show_zpform = true
		}else if(value === 'off'){
			state.show_zpform = false
		}else{
			state.show_zpform = !state.show_zpform	
		}
	},
	TOGGLEZONEPFORM (state,value) {
		if(value === 'on'){
			state.show_zonepform = true
		}else if(value === 'off'){
			state.show_zonepform = false
		}else{
			state.show_zonepform = !state.show_zonepform	
		}
	},
	TOGGLEACTPAY (state,value) {
		if(value === 'on'){
			state.show_actpay = true
		}else if(value === 'off'){
			state.show_actpay = false
		}else{
			state.show_actpay = !state.show_actpay	
		}
	},
	TOGGLEPAYSTATUS(state,value) {
		if(value && value === 'alipay') {
			state.pay_types[0].status = !state.pay_types[0].status
		}
	}
}

const actions = {
	CHECKONLINE ({commit,state}) {
		return new Promise((resolve,reject) => {
			let formData = new FormData()
			if(sessionStorage.getItem('token')){
				formData.append('token',sessionStorage.getItem('token'))
				fetch(state.api_addr + 'user/user_layout_info',{
					mode: 'cors',
					method: 'post',
					body: formData
				}).then((res) => {
					res.ok && res.json().then((json) => {
						if(json.archive.status === 0) {
							commit('TOGGLEONLINE',true)
							resolve()
						}else{
							commit('TOGGLEONLINE',false)
							sessionStorage.removeItem('token')
							reject()
						}
					})
				})
			}
			
		})
	},
	TOGGLETIP ({commit},value) {
		return new Promise((resolve,reject) => {
			commit('TOGGLETIP', value)
			resolve()
		})
	},
	CHANGEZONEINFO ({commit},value) {
		return new Promise((resolve,reject) => {
			commit('CHANGEZONEINFO', value)
			resolve()
		})
	},
	CHANGEZONETYPE ({commit},value) {
		return new Promise((resolve,reject) => {
			commit('CHANGEZONETYPE', value)
			resolve()
		})
	},
	CHANGEPAYINFO ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("CHANGEPAYINFO", value)
			resolve()
		})
	},
	CHANGEZPPAY ({commit},price) {
		return new Promise((resolve,reject) => {
			commit("CHANGEZPPAY", price)
			resolve()
		})
	},
	CHANGEPAYTABLE ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("CHANGEPAYTABLE", value)
		})
	},
	// TOGGLEALIPAY ({commit}, value) {
	// 	return new Promise((resolve,reject) => {
	// 		commit("TOGGLEALIPAY", value)
	// 		resolve()
	// 	})
	// },
	STORAGEUSERINFO ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("STORAGEUSERINFO", value)
			resolve()
		})
	},
	UNLOADUSERINFO ({commit}) {
		return new Promise((resolve,reject) => {
			commit("UNLOADUSERINFO")
			resolve()
		})
	},
	TOGGLEONLINE ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLEONLINE", value)
			resolve()
		})
	},
	TOGGLELOGIN ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLELOGIN", value)
			resolve()	
		})
	},
	TOGGLEREGISTER ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLEREGISTER", value)
			resolve()
		})
	},
	CHANGEACTID ({commit},id) {
		return new Promise((resolve,reject) => {
			commit("CHANGEACTID", id)
		})
	},
	CHANGEZPID ({commit},id) {
		return new Promise((resolve,reject) => {
			commit("CHANGEZPID", id)
		})
	},
	TOGGLEACTDETAIL ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLEACTDETAIL", value)
			resolve()
		})
	},
	TOGGLEACTFORM ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLEACTFORM", value)
			resolve()
		})
	},
	TOGGLEZPFORM ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLEZPFORM", value)
			resolve()
		})
	},
	TOGGLEZONEPFORM ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLEZONEPFORM", value)
			resolve()
		})
	},
	TOGGLEACTPAY ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLEACTPAY", value)
			resolve()
		})
	},
	TOGGLEPAYSTATUS ({commit},value) {
		return new Promise((resolve,reject) => {
			commit("TOGGLEPAYSTATUS", value)
		})
	}
}

export default new Vuex.Store({
	state,
	mutations,
	actions,
	strict: debug
})