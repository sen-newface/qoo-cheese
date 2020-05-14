import * as types from '../mutation-types';

export default {
  // ? 以下のように使える、と思う
  // getEvent({ commit }) {
  //   ...apiを叩いて、イベント情報を取得する処理
  //   ...
  //   payload = { id: ..., name: ..., photos: ... };
  //   commit(types.SET_EVENT, payload); ステートが更新される
  // }
}
