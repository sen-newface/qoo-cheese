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
    let photos = getters.getPhotosForEvnetId(event_id)
    if (!photos) {
      photos = await dispatch("setPhotosForEventId", event_id)
    }
  }
}
