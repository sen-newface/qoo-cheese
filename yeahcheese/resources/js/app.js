require('./bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
import store from './store';
import App from './app.vue';

const app = new Vue ({
    el: '#app',
    store,
    components: { App },
    template: '<App/>'
});