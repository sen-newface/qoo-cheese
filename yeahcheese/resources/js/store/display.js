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
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations
}