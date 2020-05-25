<template>
  <div id="change-columns" class="border border-dark">
    <span id="disp-columns-label">表示列数</span>
    <div v-for="idx in (min, max)" :key="idx" class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="inlineRadioOptions"
        :id="radioId(idx)"
        :value="idx"
        @change="changeColumn(idx)"
        :checked="isSelected(idx)"
      />
      <label class="form-check-label" :class="selectedNumberText(idx)" :for="radioId(idx)">{{ idx }}</label>
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
    selected: {
      // * 現在選択中のカラム数
      type: Number,
      default: 2
    }
  },
  computed: {
    radioId() {
      return idx => {
        return "radio" + idx;
      };
    },
    isSelected() {
      return idx => {
        return idx === this.selected ? "checked" : "";
      };
    },
    selectedNumberText() {
      return idx => {
        return idx === this.selected ? "is-selected-text" : "";
      };
    }
  },
  methods: {
    ...mapMutations("display", ["changeColumn"])
  }
};
</script>

<style scoped>
</style>