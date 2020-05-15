<template>
  <div id="app">
    <common-header></common-header>
    <div class="container mt-5">
        <router-view></router-view>
    </div>
  </div>
</template>

<script>
import CommonHeader from './components/CommonHeader.vue';
export default {
  name: "App",
  components: { CommonHeader }
};
</script>

<style>
</style>
