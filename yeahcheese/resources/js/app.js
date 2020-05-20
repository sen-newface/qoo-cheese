require('./bootstrap');11
import Vue from 'vue';1
import store from './store';1
import router from './router';1
import App from './app.vue';1

const createApp = async () => {
  await store.dispatch('users/getMe')
  new Vue({
    el: '#app',
    store,
    router,
    components: { App },
    template: '<App/>';
  });
}
createApp()
