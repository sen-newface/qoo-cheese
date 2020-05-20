import axios from 'axios';
import store from "./store/";

const AUTH_KEY = "auth_key";

const setApiStatus = (code = "200") => {
  return store.commit("status/setCode", code);
};

const getToken = (key = AUTH_KEY) => {
  return localStorage.getItem(key) || "";
};

const deleteToken = (key = AUTH_KEY) => {
  return localStorage.removeItem(key);
};

const setToken = (token = "", key = AUTH_KEY) => {
  return localStorage.setItem(key, token);
};


// axios
axios.defaults.headers.common['Accept'] = "application/json";
const httpWithToken = axios.create({
  headers: {
    Authorization: "Bearer " + getToken()
  }
});

httpWithToken.interceptors.request.use(request => {
  setApiStatus(200);
  return request
})

// トークン保存・更新が必要な場合はここで行う
httpWithToken.interceptors.response.use(
  (response) => {
    if (response.headers.authtoken) { setToken(response.headers.authtoken); }
    setApiStatus(response.status);
    return response;
  },
);

const onSuccess = (response) => {
  return response ? response.data : response;
};

const onError = (e) => {
  setApiStatus(e.response.status);
  return e.response.status == 422 ? e.response.data : e;
};

export default {

  // 現在のログインユーザー取得
  // 必要paramなし
  // 返却値 user json
  // トークン保存の必要あり
  getMe() {
    return httpWithToken.get("/api/user/").then(onSuccess, onError);
  },

  // ユーザー作成
  // 必要 param $user = {user: { "name", "email", "password"}}
  // 返却値 user json
  // トークン保存の必要あり
  userSignup(user) {
    return httpWithToken.post("/api/signup/", user).then(onSuccess, onError);
  },

  // login
  // 必要 param user = {user: { email", "password"}}
  // 返却値 user json
  // トークン保存の必要あり
  userLogin(user) {
    return httpWithToken.post("/api/login/", user).then(onSuccess, onError);
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
    let param = { key: key }
    httpWithToken.post("/api/events/auth", param).then(
      res => {
        setToken(res.data.key, res.data.event_id);
        return res.data;
      }
      , onError)
  },

  // イベント詳細
  // 必要 param eventのid
  // 返却値 event json
  // イベント取得、取得後 eventPhotosやるといいかな
  eventShow(id) {
    let key = getToken(id)
    return httpWithToken.get("/api/events/" + id + "?key=" + key).then(onSuccess, onError);
  },

  // イベント保存
  // 必要 param $event = {event: {name,start_date,end_date,}}
  // 返却値 event json
  eventPost(event) {
    return httpWithToken.post("/api/events/", event).then(onSuccess, onError);
  },

  // イベント編集
  // 必要 param $event_id , $event = {event: {name,start_date,end_date,}}
  // 返却値 event json
  eventUpdate(id, event) {
    return httpWithToken.put("/api/events/" + id, event).then(onSuccess, onError);
  },

  // イベント削除
  // 必要 param $event_id
  // 返却値 event json
  eventDestroy(id) {
    return httpWithToken.delete("/api/events/" + id).then(onSuccess, onError);
  },

  // イベントの写真一覧
  // 必要 param eventのid
  // 返却値 写真の json配列
  // イベントに紐付く写真を取得
  eventPhotos(id) {
    return httpWithToken.get(`/api/events/${id}/photos`).then(onSuccess, onError);
  },

  // イベントの写真 追加
  // 必要 param eventのid , $photo = {photo: {image_path}}
  // 返却値 写真の json配列
  // イベントに紐付く写真を取得
  eventPhotosPost(id, photo) {
    return httpWithToken.post(`/api/events/${id}/photos`, photo).then(onSuccess, onError);
  },

  // イベントの写真 削除
  // 必要 param eventのid , photoのid
  // 返却値 写真の json配列
  // イベントに紐付く写真を削除
  eventPhotosDestroy(id, photo_id) {
    return httpWithToken.delete(`/api/events/${id}/photos/${photo_id}`).then(onSuccess, onError);
  },
};
