import * as types from '../mutation-types';

export default {
  setUserValidationMessage(state, mes) {
    state.validationMessage = mes
  },

  setUser(state, user) {
    state.user = user
  },

  deleteUser(state) {
    state.user = {
      name: "",
      email: ""
    }
  },
}
