<template>
  <header id="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <router-link class="top-link" to="/">
        <span class="title h3">Yeahcheese</span>
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-5">
          <template v-if="isLogin">
            <li class="nav-item mr-3">
              <router-link to="/events">イベント一覧</router-link>
            </li>
            <li class="nav-item mr-3">
              <span id="logout-btn" class="text-primary" @click="logout">ログアウト</span>
            </li>
            <li class="nav-item mr-3">
              <span class="text-secondary">{{ user.name }}さんがログイン中</span>
            </li>
          </template>
          <template v-else>
            <li class="nav-item mr-3">
              <router-link to="/login">ログイン</router-link>
            </li>
            <li class="nav-item mr-3">
              <router-link to="/register">アカウント作成</router-link>
            </li>
          </template>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "CommonHeader",
  data() {
    return {};
  },
  methods: {
    ...mapActions({
      userLogout: "users/logout"
    }),
    logout() {
      this.userLogout();
    }
  },
  computed: {
    ...mapGetters({
      user: "users/user",
      isLogin: "users/isLogin"
    })
  }
};
</script>

<style scoped>
#logout-btn {
  outline: none;
  background-color: rgba(0, 0, 0, 0);
}
a,
span {
  cursor: pointer;
}
</style>
