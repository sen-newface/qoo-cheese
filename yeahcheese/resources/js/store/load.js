const state = {
  text: "",
}

const getters = {
  text: state => state.text,
}

const mutations = {
  setText(state, text = "ロード中です") {
    state.text = text
  },

  delText(state) {
    state.text = ""
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations
}
