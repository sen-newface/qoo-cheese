import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
  events: [],
  validationMessage: [],
  event: null,
}

export default {
  namespaced: true,
  state,
  mutations,
  getters,
  actions
}
