<template>
  <div id="app">
    <common-header></common-header>
    <div class="container mt-5">
        <router-view></router-view>
    </div>
  </div>
</template>

<script>
//add_auth_apiのマージが完了後 testAuth関連は削除
import login from "./pages/login";
import CommonHeader from './components/CommonHeader.vue';
export default {
  name: "App",
  components: { login,CommonHeader }
};
</script>

<style>
</style>
