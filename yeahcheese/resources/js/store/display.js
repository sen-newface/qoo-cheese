const state = {
  column: 2,
  device: 'PC'
}

const getters = {
  selectedColumns: state => state.column,
  accessDevice: state => state.device === 'PC'
}

const mutations = {
  changeColumn(state, num) {
    state.column = num;
  },
  setDevice(state, device) {
    state.device = device;
  }
}

const actions = {
  getAccessingUserDevice({ commit }) {
    if (navigator.userAgent.match(/(iPhone|iPod|Android.*Mobile)/i)) {
      console.log('now accessing is smartphone');
      commit('setDevice', 'SP');
    } else {
      console.log('now accessing is pc');
      commit('setDevice', 'PC');
    }
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations
}