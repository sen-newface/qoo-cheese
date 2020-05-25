<template>
  <div id="change-columns">
    <div v-for="idx in (min, max)" :key="idx" class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="inlineRadioOptions"
        :id="radioId(idx)"
        :value="idx"
        @change="changeColumn"
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
      type: Number,
      default: 2
    },
    max: {
      type: Number,
      default: 5
    }
  },
  methods: {
    ...mapMutations("display", ["changeColumn"])
  }
};
</script>

<style scoped>
</style>