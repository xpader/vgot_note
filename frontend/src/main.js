import Vue from 'vue'
import router from './router'
import './include/base';

//环境提示：开启的情况下，SPA 启动时会在控制台输出当前的环境相关内容
Vue.config.productionTip = false;

//import './assets/css/style.css';
import 'muse-ui/dist/muse-ui.css';

window.App = new Vue({
	el: '#app',
	router,
	data() {
		return {
			transitionName: '', //'slide-left'
		};
	},
	template: '<div id="app"><router-view class="page-container" /></div>'
});
