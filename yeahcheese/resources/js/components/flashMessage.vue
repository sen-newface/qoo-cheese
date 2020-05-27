<template>
  <div class="alert my-alert" :class="setClass" role="alert">{{ getText }}</div>
</template>

<script>
import { mapGetters } from "vuex";
import flashMessage from "../store/flashMessage";
export default {
  name: "FlashMessage",
  data() {
    return {};
  },
  computed: {
    ...mapGetters({
      getText: "flashMessage/getText",
      getClass: "flashMessage/getClass"
    }),
    setClass: function() {
      return this.getClass ? "alert-" + this.getClass : "";
    }
  }
};
</script>

<style>
.my-alert {
  text-align: center;
  margin: 10px;
  position: fixed;
  width: 92%;
  z-index: 2000;
  left: 50%;
  transform: translateX(-50%);
  -webkit-transform: translateX(-50%);
  -ms-transform: translateX(-50%);
  transition: all 0.5s ease 0s;
}
</style>
