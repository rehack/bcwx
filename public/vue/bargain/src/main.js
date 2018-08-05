import Vue from 'vue'
import App from './App.vue'
import router from '../router'
import './assets/css/base.css'
import lib from './lib/config.js'


Vue.config.productionTip = false

// vue全局变量
Vue.prototype.lib = lib




new Vue({
    router,
    render: h => h(App),
}).$mount('#app')