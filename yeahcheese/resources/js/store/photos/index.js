import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
  eventPhotos: [],// {event_id : 1, photos}のオブジェクト配列
}

export default {
  namespaced: true,
  state,
  mutations,
  getters,
  actions
}
