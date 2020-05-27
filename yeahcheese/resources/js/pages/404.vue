<template>
  <!-- デザインは後々修正する -->
  <div class="error-container alert alert-secondary" role="alert">ページが存在しません</div>
</template>

<script>
export default {
  name: "E404",
  created() {
    this.$store.commit("flashMessage/setTextAndClass", {
      text: "ページが見つかりませんでした。",
      cls: "danger"
    });
  }
};
</script>

<style>
</style>
