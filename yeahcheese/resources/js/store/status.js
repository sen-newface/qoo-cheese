const state = {
  code: 200,
}

const getters = {
  code: state => state.code,
  isApiSuccess: state => {
    var codeTop = state.code.toString().slice(0, 1);
    if (codeTop == 2) {
      return true;
    } else {
      return false;
    }
  }
}

const mutations = {
  setCode(state, code) {
    state.code = code
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations
}
