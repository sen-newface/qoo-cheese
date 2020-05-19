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
  }
}
