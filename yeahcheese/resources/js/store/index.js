import Vue from 'vue';
import Vuex from 'vuex';
import users from './users';
import events from './events';
import photos from './photos';
import status from './status';
import load from './load';
import storage from './storage'
import flashMessage from './flashMessage';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    users,
    events,
    photos,
    status,
    load,
    storage
    flashMessage,
  }
});

export default store;
