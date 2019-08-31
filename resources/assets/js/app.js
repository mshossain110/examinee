/* eslint-disable no-unused-vars */
// Event bus
import Dropzone from './components/common/dropzone'
const VueRouter = require('vue-router').default

window.EventBus = new Vue()

Vue.component('PageScholar', require('./components/course/PageScholar.vue').default)

Vue.use(Dropzone)
// eslint-disable-next-line no-unused-vars
Vue.use(VueRouter)
const router = new VueRouter({
    mode: 'history',
    scrollBehavior () {
        return { x: 0, y: 0 }
    }
})

const app = new Vue({
    el: '#app',
    router
})

// eslint-disable-next-line no-console
console.log('%c Warning! %c If you are not developer, this may be dangerous for you account.', 'background: yellow; color: black; font-size: 24px; font-weight: bold;', 'background: red; color: white; font-size: 24px;')
