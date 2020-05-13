require('./bootstrap');
import Vue from 'vue';
import store from './store';
import router from './router';
import App from './app.vue';

const app = new Vue ({
    el: '#app',
    store,
    router,
    components: { App },
    template: '<App/>'
});
