
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('@fortawesome/fontawesome-free/js/fontawesome');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// Vue.component('plyr-video', require('vue-plyr/dist/vue-plyr'));
Vue.component('user-info', require('./components/UserInfo.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('video-list', require('./components/VideoList.vue'));
Vue.component('videos', require('./components/Videos.vue'));
Vue.component('test-api', require('./components/TestAPI.vue'));
Vue.component('video-details', require('./components/VideoDetails.vue'));
Vue.component('avatar-crope', require('./components/AvatarCrope.vue'));

const app = new Vue({
    el: '#app'
});
