import Vue from 'vue';

import storage from './store';
import Vuex from 'vuex';
Vue.use(Vuex);

const store = new Vuex.Store(storage);


export default store;