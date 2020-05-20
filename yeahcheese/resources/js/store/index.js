import Vue from 'vue';
import Vuex from 'vuex';
import users from './users';
import events from './events';
import photos from './photos';
import status from './status';
import load from './load'

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    users,
    events,
    photos,
    status,
    load
  }
});

export default store;
