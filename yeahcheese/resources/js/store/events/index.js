import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
  events: [],
  page_per_events: 5,
  last_page: 1,
  curretEventPage: 1,
  initLoad: true,
  validationMessage: []
}

export default {
  namespaced: true,
  state,
  mutations,
  getters,
  actions
}
