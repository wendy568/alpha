// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import { sync } from 'vuex-router-sync'
import fetch from 'isomorphic-fetch'
import router from './routes/routes'
import store from './vuex/store'
import VueResource from 'vue-resource'
import Validator from 'vue-validator'

Vue.use(VueResource)
Vue.use(Validator)

sync(store,router)

/* eslint-disable no-new */
new Vue({
  router: router,
  store,
  render: h => h(App)
}).$mount('#app')
