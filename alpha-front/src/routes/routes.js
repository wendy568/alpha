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
		name: 'act',
	},
	{
		path: '/act_detail', 
		component: (resolve) => {
			require(['../components/Act_detail'], resolve)
		},
		name: 'act_detail'
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
				},
				children:[
					{
						path: 'event_order', 
						component: (resolve) => {
							require(['../components/Event_order'], resolve)
						}
					},
					{
						path: 'tr_fl_order', 
						component: (resolve) => {
							require(['../components/Tr_fl_order'], resolve)
						}
					},
					{
						path: 'zone_plus_order', 
						component: (resolve) => {
							require(['../components/Zone_plus_order'], resolve)
						}
					}
				] 
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
	mode:'history',
	routes: routes,
	linkActiveClass: 'active',
	// history: true
})

export default router