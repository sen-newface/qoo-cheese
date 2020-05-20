import * as types from '../mutation-types';
import api from "../../api"
import store from "../../store"

export default {
  async getEvents(context) {
    let response = await api.eventIndex();
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      context.commit("setEvents", response.data);
      return response
    }
  },

  async initGetEvents(context) {
    if (store.getters["events/initLoad"]) {
      let response = await api.eventIndex();
      const isSuccess = store.getters["status/isApiSuccess"];
      if (isSuccess) {
        context.commit("setEvents", response.data);
        context.commit("setInitLoad", false);
        return response
      }
    }
  },
  async eventStore(context, data) {
    let response = await api.eventPost(data);
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      context.commit("setEvent", response);
      context.commit("flashMessage/setTextAndClass",{text: "イベント作成に成功しました", cls: "success"}, {root: true});
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
    store.commit("photos/delPhotos")
    store.commit("events/resetEvent")
  }
}
