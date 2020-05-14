import axios from 'axios';

const getToken = () => {
  return localStorage.getItem("authKey") || "tokenTest"
}

const deleteToken = () => {
  return localStorage.removeItem("authKey");
}

const tokenHeader = {
  Accept: "application/json",
  Authorization: "Bearer " + getToken()
}

////トークン保存を伴わないaxios auth認定が必要な処理
const httpWithToken = axios.create({
  tokenHeader
})

////トークン保存を伴うaxios
const httpWithTokenAndStore = axios.create({
  tokenHeader
})

//トークン保存・更新が必要な場合はここで行う
httpWithTokenAndStore.interceptors.response.use((response) => {
  if (response.data && response.data.token) { localStorage.setItem("authKey", response.data.token); }
  return response
})

const toSuccess = (response) => {
  console.log(response.data)
  return response.data
}

const toError = (e) => {
  console.log(e)
  return e
}

export default {

  // 現在のログインユーザー取得
  // 必要paramなし
  // 返却値 user json
  //トークン保存の必要あり
  getMe() {
    return httpWithTokenAndStore.get("/api/user/").then(toSuccess, toError)
  },

  // ユーザー作成
  // 必要 param $user = {user: { "name", "email", "password"}}
  // 返却値 user json
  // トークン保存の必要あり
  userSignup($user) {
    return httpWithTokenAndStore.post("/api/signup/", $user).then(toSuccess, toError)
  },

  // login
  // 必要 param $user = {user: { email", "password"}}
  // 返却値 user json
  // トークン保存の必要あり
  userLogin($user) {
    return httpWithTokenAndStore.post("/api/login/", $user).then(toSuccess, toError)
  },

  // logout
  // 必要 param なし
  // 返却値なし
  // トークンの削除　APIの処理は伴わないが今のところこちらに書いておく
  userLogout() {
    deleteToken
  },

  //イベント認証キーチェック
  //必要param なし
  //返却値 event: {"id", "key"}
  //イベントの認証のみを行う,返却値 id をkey 返却値 keyをvalueにしてlocalstrageに保存
  //インターセプトで実装かな
  eventAuth($key) {
    return axios.post("/api/events/auth", $key).then(toSuccess, toError)
  },

  //イベント詳細
  //必要 param eventのid
  // 返却値 event json
  // イベント取得、取得後 eventPhotosやるといいかな
  eventShow($id) {
    //FIXME
    //ログインしてたらそのまま
    //ログインしてなかったら localstrageから撮ってきた keyを入れる。
    return httpWithToken.get("/api/events/" + $id).then(toSuccess, toError)
  },

  //イベント保存
  //必要 param $event = {event: {name,start_date,end_date,}}
  // 返却値 event json
  eventPost($event) {
    return httpWithToken.post("/api/events/", $event).then(toSuccess, toError)
  },

  //イベント編集
  //必要 param $event_id , $event = {event: {name,start_date,end_date,}}
  // 返却値 event json
  eventUpdate($id, $event) {
    return httpWithToken.put("/api/events/" + $id, $event).then(toSuccess, toError)
  },

  //イベント削除
  //必要 param $event_id
  // 返却値 event json
  eventUpdate($id) {
    return httpWithToken.delete("/api/events/" + $id).then(toSuccess, toError)
  },

  //イベントの写真一覧
  //必要 param eventのid
  // 返却値 写真の json配列
  // イベントに紐付く写真を取得
  eventPhotos($id) {
    return httpWithToken.get(`/api/events/${$id}/photos`).then(toSuccess, toError)
  },

  //イベントの写真 追加
  //必要 param eventのid , $photo = {photo: {image_path}}
  // 返却値 写真の json配列
  // イベントに紐付く写真を取得
  eventPhotosPost($id, $photo) {
    return httpWithToken.post(`/api/events/${$id}/photos`, $photo).then(toSuccess, toError)
  },

  //イベントの写真 削除
  //必要 param eventのid , photoのid
  // 返却値 写真の json配列
  // イベントに紐付く写真を削除
  eventPhotosPost($id, $photo_id) {
    return httpWithToken.delete(`/api/events/${$id}/photos/${$photo_id}`).then(toSuccess, toError)
  },
}
