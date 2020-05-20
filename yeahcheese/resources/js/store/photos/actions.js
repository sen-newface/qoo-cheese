import * as types from '../mutation-types';
import api from "../../api";
import store from "../../store";

export default {
  async postPhoto({ commit }, { id, data }) {
    const response = await api.eventPhotosPost(id, data);
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      // commit("appendPhoto", response);
      return response;
    } else {
      return response.errors;
    }
  }
}
