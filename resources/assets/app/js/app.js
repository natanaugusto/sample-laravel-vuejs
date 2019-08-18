require('./bootstrap')

window.Vue = require('vue')

import BootstrapVue from 'bootstrap-vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Main from './components/Main.vue'
import router from './router'
import store from './store'

Vue.use(BootstrapVue)
Vue.component('font-awesome-icon', FontAwesomeIcon)

const app = new Vue({
    store,
    router,
    el: '#app',
    render: h => h(Main)
})
