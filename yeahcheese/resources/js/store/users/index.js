import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
  user: {
    name: "",
    email: ""
  },
  validationMessage: []
}

export default {
  namespaced: true,
  state,
  mutations,
  getters,
  actions
}
