require('./bootstrap');
import Vue from 'vue';
import store from './store';
import router from './router';
import App from './app.vue';

const createApp = async () => {
  await store.commit("storage/setAllDates")
  await store.dispatch('users/getMe')
  new Vue({
    el: '#app',
    store,
    router,
    components: { App },
    template: '<App/>'
  });
}
createApp()
