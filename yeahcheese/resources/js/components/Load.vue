<template>
  <div class="load_warpper" v-if="loadText">
    <div class="box">
      <img src="/image/load.gif" alt />
      <p>{{loadText}}</p>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      loadText: "load/text"
    })
  }
};
</script>

<style>
.load_warpper {
  position: absolute;
  z-index: 100;
  width: 100vw;
  height: 100vh;
  background-color: gray;
  opacity: 0.4;
}

.box {
  text-align: center;
  position: absolute;
  color: white;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
}
</style>
