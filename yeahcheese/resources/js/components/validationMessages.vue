<template>
  <ul v-if="errors.length" class="list-group mb-2">
    <li
      v-for="error in errors"
      :key="error"
      class="list-group-item list-group-item-danger"
    >・{{error}}</li>
  </ul>
</template>

<script>
export default {
  props: {
    errors: {
      type: Array,
      default: () => []
    }
  }
};
</script>
