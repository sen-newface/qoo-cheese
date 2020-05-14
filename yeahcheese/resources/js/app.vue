<template>
  <div id="app">
    <div class="container mt-5">
        <router-view></router-view>
    </div>
  </div>
</template>

<script>
//add_auth_apiのマージが完了後 testAuth関連は削除
import login from "./pages/login";
export default {
  name: "App",
  components: { login }
};
</script>

<style>
</style>
