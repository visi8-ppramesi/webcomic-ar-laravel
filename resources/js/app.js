require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

import router from './Router/router';
import store from './Store/store';
import App from './App.vue'

Vue.use(VueRouter)

const app = new Vue({
    el: '#app',
    router,
    store,
    components: { App }
})