<template>
  <div id="app">
    <router-view></router-view>
    <testAuth></testAuth>
  </div>
</template>

<script>
//add_auth_apiのマージが完了後 testAuth関連は削除
import testAuth from "./tmpAuthTest";
export default {
  name: "App",
  components: { testAuth }
};
</script>

<style>
</style>
