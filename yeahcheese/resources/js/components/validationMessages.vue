<template>
  <ul v-if="errors.length" class="list-group mb-2">
    <li v-for="er in errors" :key="er" class="list-group-item list-group-item-danger">・{{er}}</li>
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
