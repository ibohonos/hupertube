
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('@fortawesome/fontawesome-free/js/fontawesome');

window.Vue = require('vue');
window.Lang = require('vuejs-localization');
window.CyrToLat = require('./plugins/CyrToLat/cyr-to-lat');
window.currentLang = document.head.querySelector('meta[name="lang"]').content;

// import CyrillicToTranslit = require(".");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// Vue.component('plyr-video', require('vue-plyr/dist/vue-plyr'));
Vue.component('user-info', require('./components/UserInfo.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('viewed', require('./components/ViewedInfo.vue'));
Vue.component('view-later', require('./components/ViewLaterInfo.vue'));
Vue.component('video-list', require('./components/VideoList.vue'));
Vue.component('serials-list', require('./components/SerialsList.vue'));
Vue.component('all-view-later', require('./components/ViewLaterList.vue'));
Vue.component('videos', require('./components/Videos.vue'));
Vue.component('serials', require('./components/Serials.vue'));
Vue.component('test-api', require('./components/TestAPI.vue'));
Vue.component('video-details', require('./components/VideoDetails.vue'));
Vue.component('serial-details', require('./components/SerialDetails.vue'));
Vue.component('avatar-crope', require('./components/AvatarCrope.vue'));


Lang.requireAll(require.context('./lang', true, /\.js$/));
Vue.use(Lang);
Vue.use(CyrToLat, {preset: 'uk'});

// window.VuePlyr = require('vue-plyr');
// import VuePlyr from 'vue-plyr';
// import 'vue-plyr/dist/vue-plyr.css';
// Vue.use(VuePlyr);

const app = new Vue({
	el: '#app'
});
