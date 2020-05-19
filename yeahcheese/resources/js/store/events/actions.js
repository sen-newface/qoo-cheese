import * as types from '../mutation-types';
import api from "../../api";
import store from "../../store";

export default {
  async eventStore(context, data) {
    let response = await api.eventPost(data);
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      context.commit("setEvent", response);
      return response
    } else {
      return response.errors;
    }
  },

  async setEventForId(context, event_id) {
    let response = await api.eventShow(event_id)
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      context.commit("setEvent", response);
      return response
    } else {
      return response.errors;
    }
  },

  async getEventsAndPhotosIfNotExits({ dispatch, getters }, event_id) {
    let event = getters.getEventForId(event_id)
    if (!event) {
      event = await dispatch("setEventForId", event_id)
    }
    if (event) await store.dispatch("photos/getPhotosIfNotExits", event_id);
  },

  resetEventAndPhotos({ context }) {
    store.commit("events/delEvents")
    store.commit("photos/delPhotos")
  }
}
