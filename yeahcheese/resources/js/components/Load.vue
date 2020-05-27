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
import scrollControllable from "../mixins/scrollControllable";
export default {
  computed: {
    ...mapGetters({
      loadText: "load/text"
    })
  },
  watch: {
    loadText: {
      handler(val) {
        if (val) {
          this.no_scroll();
        } else {
          this.return_scroll();
        }
      },
      immediate: true
    }
  },
  mixins: [scrollControllable]
};
</script>

<style>
.load_warpper {
  position: fixed;
  z-index: 100;
  width: 100vw;
  height: 100vh;
  background: rgba(45, 45, 45, 0.5);
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
