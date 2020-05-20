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
      return response
    } else {
      return response.errors;
    }
  }
}
