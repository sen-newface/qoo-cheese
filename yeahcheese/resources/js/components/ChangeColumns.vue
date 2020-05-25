<template>
  <div id="change-columns">
    <div v-for="idx in (min, max)" :key="idx" class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="inlineRadioOptions"
        :id="radioId(idx)"
        :value="idx"
        @change="changeColumn(idx)"
      />
      <label class="form-check-label" :for="radioId(idx)">{{ idx }}</label>
    </div>
  </div>
</template>

<script>
import { mapMutation, mapMutations } from "vuex";
export default {
  name: "ChangeColumns",
  props: {
    min: {
      // * 表示する列数の最小値
      type: Number,
      default: 2
    },
    max: {
      // * 最大何列まで表示できるかの情報
      type: Number,
      default: 5
    },
    device: {
      // * アクセスしてきたデバイスの種類（未使用）
      type: Boolean,
      default: true
    },
    dispStyle: {
      // * 何列で表示するかの情報
      type: Number,
      default: 2
    }
  },
  methods: {
    ...mapMutations("display", ["changeColumn"])
  }
};
</script>

<style scoped>
</style>