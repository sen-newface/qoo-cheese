import Vue from 'vue';
import Vuex from 'vuex';
import users from './users';
import events from './events';
import photos from './photos';
import status from './status';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    users,
    events,
    photos,
    status
  }
});

export default store;
