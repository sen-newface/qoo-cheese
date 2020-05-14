import * as types from '../mutation-types';

export default {
  // ? 以下のように使える、と思う
  // getUser({ commit }) {
  //   ...apiを叩いて、ユーザー情報を取得する処理
  //   ...
  //   payload = { id: ..., name: ..., email: ... };
  //   commit(types.SET_USER, payload); ステートが更新される
  // }
}
