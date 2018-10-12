import Vue from 'vue'
import router from './router'

//环境提示：开启的情况下，SPA 启动时会在控制台输出当前的环境相关内容
Vue.config.productionTip = false;

import './assets/css/style.css';

const app = new Vue({
	el: '#app',
	router,
	data() {
		return {
			transitionName: '', //'slide-left'
		};
	},
	template: '<div id="app"><router-view class="page-frame" /></div>'
});

window.getApp = () => {
	return app;
};

//检测对象是否为空
Object.isEmpty = function (obj) {
	return Object.keys(obj).length == 0;
};

//克隆对象
Object.clone = obj => {
	return JSON.parse(JSON.stringify(obj));
};
