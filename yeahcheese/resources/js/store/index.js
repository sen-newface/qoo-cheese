import Vue from 'vue';
import Vuex from 'vuex';
import users from './users';
import events from './events';
import photos from './photos';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    users,
    events,
    photos
  }
});

export default store;
