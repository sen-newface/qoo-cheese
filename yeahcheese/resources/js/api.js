import axios from 'axios';
import store from "./store/";
import { Route } from "./constants";

const AUTH_KEY = "auth_key";

const setApiStatus = (code = "200") => {
  return store.commit("status/setCode", code);
};

const delLoding = () => {
  store.commit("load/delText");
};

const setLoding = (text = "ロード中です") => {
  store.commit("load/setText", text);
};

const getToken = (key = AUTH_KEY) => {
  let val = store.getters["storage/getValueForkey"](key)
  return val || "";
};

const deleteToken = (key = AUTH_KEY) => {
  return store.commit("storage/delData", key)
};

const setToken = (token = "", key = AUTH_KEY) => {
  return store.commit("storage/setData", { key: key, value: token })
};


// axios
axios.defaults.headers.common['Accept'] = "application/json";
const httpWithToken = axios.create({
  // headers: {
  //   Authorization: "Bearer " + getToken()
  // }
});

httpWithToken.interceptors.request.use(request => {
  request.headers['Authorization'] = "Bearer " + getToken();
  setApiStatus(200);
  return request;
})

// トークン保存・更新が必要な場合はここで行う
httpWithToken.interceptors.response.use(
  (response) => {
    if (response.headers.authtoken) { setToken(response.headers.authtoken); }
    setApiStatus(response.status);
    delLoding();
    return response;
  },
);

const onSuccess = (response) => {
  return response ? response.data : response;
};

const onError = (e) => {
  setApiStatus(e.response.status);
  delLoding();
  return e.response.status == 422 ? e.response.data : e;
};

export default {

  // 現在のログインユーザー取得
  // 必要paramなし
  // 返却値 user json
  // トークン保存の必要あり
  getMe() {
    setLoding("ユーザー取得中です")
    return httpWithToken.get(Route.AUTH_ME).then(onSuccess, onError);
  },

  // ユーザー作成
  // 必要 param $user = {user: { "name", "email", "password"}}
  // 返却値 user json
  // トークン保存の必要あり
  userSignup(user) {
    setLoding("アカウント作成中です")
    return httpWithToken.post(Route.AUTH_SIGNUP, user).then(onSuccess, onError);
  },

  // login
  // 必要 param user = {user: { email", "password"}}
  // 返却値 user json
  // トークン保存の必要あり
  userLogin(user) {
    setLoding("ログイン中です")
    return httpWithToken.post(Route.AUTH_LOGIN, user).then(onSuccess, onError);
  },

  // logout
  // 必要 param なし
  // 返却値なし
  // トークンの削除　APIの処理は伴わないが今のところこちらに書いておく
  userLogout() {
    deleteToken();
  },

  // イベント認証キーチェック
  // 必要param {$key 認証キーです}
  // 返却値 event: {"id", "key"}
  // イベントの認証のみを行う,返却値 id をkey 返却値 keyをvalueにしてlocalstrageに保存
  eventAuth(key) {
    setLoding("イベントのkeyを照合しています")
    let param = { key: key }
    return httpWithToken.post(Route.EVENTS_AUTH, param).then(
      res => {
        const key = "event-" + res.data.id
        setToken(res.data.key, key);
        setApiStatus(res.status);
        return res.data;
      }
      , onError)
  },

  // イベント一覧
  // 必要 なし
  // 返却値 events json
  // イベント取得、取得後
  eventIndex() {
    setLoding("イベントを取得しています")
    return httpWithToken.get(Route.EVENTS_INDEX).then(onSuccess, onError);
  },

  // イベント詳細
  // 必要 param eventのid
  // 返却値 event json
  // イベント取得、取得後 eventPhotosやるといいかな
  eventShow(id) {
    let key = getToken("event-" + id)
    setLoding("イベント読み込み中です")
    return httpWithToken.get(Route.EVENTS_SHOW(id, key)).then(onSuccess, onError);
  },

  // イベント保存
  // 必要 param $event = {event: {name,start_date,end_date,}}
  // 返却値 event json
  eventPost(event) {
    setLoding("イベント登録中です")
    return httpWithToken.post(Route.EVENTS_STORE, event).then(onSuccess, onError);
  },

  // イベント編集
  // 必要 param $event_id , $event = {event: {name,start_date,end_date,}}
  // 返却値 event json
  eventUpdate(id, $event) {
    setLoding("イベントアップデート中です")
    return httpWithToken.put(Route.EVENTS_UPDATE(id), $event).then(onSuccess, onError);
  },

  // イベント削除
  // 必要 param $event_id
  // 返却値 event json
  eventDestroy(id) {
    setLoding("イベント削除中です")
    return httpWithToken.delete(Route.EVENTS_DESTROY(id)).then(onSuccess, onError);
  },

  // イベントの写真一覧
  // 必要 param eventのid
  // 返却値 写真の json配列
  // イベントに紐付く写真を取得
  eventPhotos(id) {
    setLoding("イベントの写真を取得しています")
    return httpWithToken.get(Route.PHOTOS_INDEX(id)).then(onSuccess, onError);
  },

  // イベントの写真 追加
  // 必要 param eventのid , $photos = [{image_path: "aaaa", title: "aaaaaaaaa"}]
  // 返却値 写真の json配列
  // イベントに紐付く写真を取得
  eventPhotosPost(id, photos) {
    setLoding("イベントに写真を登録しています")
    return httpWithToken.post(Route.PHOTOS_STORE(id), photos).then(onSuccess, onError);
  },

  // イベントの写真 削除
  // 必要 param eventのid , photoのid
  // 返却値 写真の json配列
  // イベントに紐付く写真を削除
  eventPhotosDestroy(id, photo_id) {
    setLoding("イベントの写真を削除しています")
    return httpWithToken.delete(Route.PHOTOS_DESTROY(id, photo_id)).then(onSuccess, onError);
  },
};
