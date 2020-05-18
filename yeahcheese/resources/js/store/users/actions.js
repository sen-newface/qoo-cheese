import * as types from '../mutation-types';
import api from "../../api";
import store from "../../store";

export default {
  async getMe(context) {
    let response = await api.getMe();
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      context.commit("setUser", response);
      return response
    }
    return false;
  },

  async register(context, data) {
    let response = await api.userSignup(data);
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      context.commit("setUser", response);
      return response
    } else {
      return response.errors;
    }
  },

  async login(context, data) {
    let response = await api.userLogin(data);
    const isSuccess = store.getters["status/isApiSuccess"];
    if (isSuccess) {
      context.commit("setUser", response);
      return response;
    }
    return false;
  },

  async logout(context) {
    let res = await api.userLogout();
    context.commit("deleteUser")
    store.commit("events/resetEvent")
    return true;
  },
}
