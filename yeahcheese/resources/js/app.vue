<template>
  <div id="app">
    <loader />
    <common-header />
    <flash-message></flash-message>
    <div class="container mt-5">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import CommonHeader from "./components/CommonHeader.vue";
import FlashMessage from "./components/flashMessage.vue";
import Loader from "./components/Load.vue";
import { mapGetters } from "vuex";
export default {
  name: "App",
  components: {
    CommonHeader,
    FlashMessage,
    Loader
  },
  computed: {
    ...mapGetters({
      code: "status/code"
    })
  },
  watch: {
    code: {
      handler(val) {
        switch (val) {
          case 500:
            this.$router.push("/500");
            break;
          case 404:
            this.$router.push("/404");
            break;
          case 403:
            this.$router.push("/403");
            break;
          case 401:
            if (this.$route.path !== "/login") this.$router.push("/login");
            break;
          default:
        }
      }
    }
  }
};
</script>
