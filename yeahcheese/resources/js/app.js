require('./bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
import App from './app.vue';

Vue.use(Vuex);

const app = new Vue ({
    el: '#app',
    components: { App },
    template: '<App/>'
});