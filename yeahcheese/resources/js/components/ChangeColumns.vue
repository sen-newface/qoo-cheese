<template>
  <div id="change-columns" class="border border-dark">
    <span id="disp-columns-label">表示列数</span>
    <div v-for="idx in range(min, max)" :key="idx" class="form-check form-check-inline">
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
    },
    range() {
      return (min, max) => {
        let rangeList = [];
        for (let i = min; i <= max; i++) {
          rangeList.push(i);
        }
        return rangeList;
      };
    }
  },
  methods: {
    ...mapMutations("display", ["changeColumn"])
  }
};
</script>

<style scoped>
#change-columns input[type="radio"] {
  display: inline-block;
  margin-left: 16px;
}
#change-columns {
  display: flex;
  align-items: center;
  border-radius: 5px;
  padding: 0 0 0 8px;
  margin-left: 16px;
  color: rgba(20, 20, 20, 0.7);
}
.is-selected-text {
  color: cornflowerblue;
  font-weight: bold;
  text-shadow: 0 0 10px cornflowerblue 0 0 15px cornflowerblue;
}
</style>