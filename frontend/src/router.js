import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
	mode: 'hash',
	routes: [
		{
			path: '/',
			name: 'Home',
			component:  R => require(['@/pages/index'], R)
		}, {
			path: '*',
			component: R => require(['@/pages/common/404'], R)
		}
	]
})
