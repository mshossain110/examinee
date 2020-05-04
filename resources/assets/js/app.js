/* eslint-disable no-unused-vars */
// Event bus
import Dropzone from './components/common/dropzone'
import Vuex from 'vuex'
import mixin from './mixin/mixin'
const VueRouter = require('vue-router').default

window.EventBus = new Vue()
Vue.use(Dropzone)
Vue.use(Vuex)

Vue.component('Loading', require('./components/common/Loading.vue').default)
Vue.component('PageScholar', require('./components/course/PageScholar.vue').default)
Vue.component('PageStudent', require('./components/students/PageStudent.vue').default)
Vue.component('Course', require('./components/common/Course.vue').default)
Vue.component('SingleCourse', require('./components/SingleCourse/SingleCourse.vue').default)

const store = new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production'
})
// eslint-disable-next-line no-unused-vars
Vue.use(VueRouter)
const router = new VueRouter({
    mode: 'history',
    scrollBehavior () {
        return { x: 0, y: 0 }
    }
})

Vue.mixin(mixin)
const app = new Vue({
    el: '#app',
    router,
    store
})

// eslint-disable-next-line no-console
console.log('%c Warning! %c If you are not developer, this may be dangerous for you account.', 'background: yellow; color: black; font-size: 24px; font-weight: bold;', 'background: red; color: white; font-size: 24px;')
