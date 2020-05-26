const state = {
  text: "",
  class: ""
}

const getters = {
  getText: state => state.text,
  getClass: state => state.class
}

const mutations = {
  setTextAndClass(state, { text, cls = "primary" }) {
    state.text = text
    state.class = cls

    let timeout = 3000
    setTimeout(() => (state.text = '', state.class = ''), timeout)
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations
}
