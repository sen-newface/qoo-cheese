<template>
  <div class="alert my-alert" :class="setClass" role="alert" >
    {{ getText }}
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import flashMessage from '../store/flashMessage';
export default {
  name: 'FlashMessage',
  data() {
    return {
    }
  },
  computed: {
    ...mapGetters({
      getText: 'flashMessage/getText',
      getClass: 'flashMessage/getClass',
    }),
    setClass(){
        return this.getClass ? 'alert-' + this.getClass : ""
    }
  }
};
</script>

<style>
.my-alert{
    text-align: center;
    margin: 10px;
}
</style>