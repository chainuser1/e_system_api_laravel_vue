/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

// import plugin

import router from './router';
import policies from './policies';
import store from './store';
Vue.prototype.authorize = (policy, model)=>{
    if (!store.getters['auth'].isAutneticated) return false;

    if(typeof policy === 'string' && typeof model === 'object'){
        // get user from store 
        const user = store.getters.user
        return policies[policy](user, model);
        // authorize(user, model);
    }
}

// use plugin

import VueIziToast from 'vue-izitoast';



import 'izitoast/dist/css/iziToast.min.css';
import Vue from 'vue';

Vue.use(VueIziToast,{
    position: 'topRight',
});

// load AuthNav.vue component
Vue.component('base-page', require('./pages/BasePage.vue').default);
// load example vue component

const app = new Vue({
    el: '#app',
    router,
    store,
});
