
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');
window.Vue = require('vue');

import VueResource from 'vue-resource';

Vue.use(VueResource);


// vue components
Vue.component('examnotify', require('./components/ExamNotify.vue'));

const app = new Vue({
	el: '#notify'
});