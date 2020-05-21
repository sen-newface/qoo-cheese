const state = {
  datas: []// {key: "aaa", value: "aaaaaa"}
}

const getters = {
  getValueForkey: state => (key) => {
    const target = state.datas.find(data => data.key == key);
    return target ? target.value : null;
  },
}

const mutations = {
  delData(state, key) {
    state.datas = state.datas.filter((data) => data.key !== key);
    localStorage.removeItem(key)
  },

  setData(state, { key = "key", value = "value" }) {
    let data = { key: key, value: value }
    state.datas.push(data)
    localStorage.setItem(key, value);
  },

  setAllDatas(state) {
    Object.keys(localStorage).forEach(function (key) {
      state.datas.push({ key: key, value: localStorage.getItem(key) })
    });
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations
}
