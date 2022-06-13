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

Vue.prototype.authorize = (policy, model)=>{
    if(!window.Auth.signedIn) return false;

    if(typeof policy === 'string' && typeof model === 'object'){
        const user = window.Auth.user;
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


const app = new Vue({
    el: '#app',
    router
});
