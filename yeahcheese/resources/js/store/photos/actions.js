import * as types from '../mutation-types';
import api from "../../api";
import store from "../../store";

export default {
  async postPhoto(context, { id, data }) {//idはevent_id
    const response = await api.eventPhotosPost(id, data);
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      context.commit("addPhotoByEventId", { event_id: id, photo: response });
      context.commit("events/setEventPreview", { id: id, photo: response }, { root: true });
      context.commit("flashMessage/setTextAndClass", { text: "写真の保存に成功しました", cls: "success" }, { root: true });
      return response;
    } else {
      return response.errors;
    }
  },
  async setPhotosForEventId(context, event_id) {
    let response = await api.eventPhotos(event_id)
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      const data = { event_id: event_id, photos: response }
      context.commit("setEventPhotos", data);
      return response
    } else {
      return response.errors;
    }
  },
  async getPhotosIfNotExits({ dispatch, commit, getters }, event_id) {
    let photos = getters.getPhotosForEventId(event_id)
    if (!photos) {
      photos = await dispatch("setPhotosForEventId", event_id)
    }
  },

  async deletePhoto({ dispatch, commit, getters }, { event_id, photo_id }) {

    let response = await api.eventPhotosDestroy(event_id, photo_id)
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      let photo_index = getters.getPhotoIndexForEventId(event_id, photo_id)
      commit("delPhotoByEventId", { event_id: event_id, photo_index: photo_index });
      commit("events/updateEventPreviews", { event_id: event_id, photos: getters.getPhotosForEventId(event_id) }, { root: true });
      commit("flashMessage/setTextAndClass", { text: "写真の削除に成功しました", cls: "success" }, { root: true });
      return response
    } else {
      return response.errors;
    }
  },
  async photoLikesIndex({ commit }) {
    const response = await api.photoLikesIndex();
    const isSuccess = store.getters['status/isApiSuccess'];
    if (isSuccess) {
      commit("setLikedPhotos", response.data);
      return response;
    }
  },
  async photoLikesStore({ commit }, likesId) {
    const response = await api.photoLikesStore(likesId);
    const isSuccess = store.getters['status/isApiSuccess'];
    if (isSuccess) {
      commit("pushLikedPhoto", response.data);
    }
  },
  async photoLikesDestroy({ commit }, dislikesId) {
    const response = await api.photoLikesDestroy(dislikesId);
    const isSuccess = store.getters['status/isApiSuccess'];
    if (isSuccess) {
      commit("deleteLikedPhoto", response.data);
    }
  }
}
