import Vue from 'vue'
import VueRouter from 'vue-router'
import App from '../App'

Vue.use(VueRouter)

const routes = [
	{
		path: '/',
		component: (resolve) => {
			require(['../components/Home'], resolve)
		},
		name: 'home'
	},
	{
		path: '/act',
		component: (resolve) => {
			require(['../components/Act'], resolve)
		},
		name: 'act'
	},
	{
		path: '/tv_detail',
		component: (resolve) => {
			require(['../components/Tv_detail'], resolve)
		},
		name: 'tv_detail'
	},
	{
		path: '/tv_list',
		component: (resolve) => {
			require(['../components/Tv_list'], resolve)
		},
		name: 'tv_list'
	},
	{
		path: '/zone',
		component: (resolve) => {
			require(['../components/Zone'], resolve)
		},
		name: 'zone'
	},
	{
		path: '/zoneplus',
		component: (resolve) => {
			require(['../components/Zoneplus'], resolve)
		},
		name: 'zoneplus'
	},
	{
		path: '/personal',
		component: (resolve) => {
			require(['../components/Personal'], resolve)
		},
		name: 'personal',
		children: [
			{ 
				path: 'profile', 
				component: (resolve) => {
					require(['../components/Profile'], resolve)
				}
			},
			{ 
				path: 'favorite', 
				component: (resolve) => {
					require(['../components/Favorite'], resolve)
				} 
			},
			{ 
				path: 'order', 
				component: (resolve) => {
					require(['../components/Order'], resolve)
				} 
			}
		]
	},
	{
		path: '/payBack',
		component: (resolve) => {
			require(['../components/Pay_callback'], resolve)
		},
		name: 'payBack'
	},
]

const router = new VueRouter({
	routes: routes,
	linkActiveClass: 'active',
	history: true
})

export default router