<template>
  <div id="app">
    <common-header></common-header>
    <div class="container mt-5">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import CommonHeader from "./components/CommonHeader.vue";
import { mapGetters } from "vuex";
export default {
  name: "App",
  components: {
    CommonHeader
  },
  computed: {
    ...mapGetters({
      code: "status/code"
    })
  },
  watch: {
    code: {
      async handler(val) {
        if (val === 500) {
          this.$router.push("/500");
        } else if (val === 404) {
          this.$router.push("/404");
        } else if (val === 403) {
          this.$router.push("/403");
        } else if (val === 403) {
          this.$router.push("/login");
        }
      }
    }
  }
};
</script>

<style>
</style>
