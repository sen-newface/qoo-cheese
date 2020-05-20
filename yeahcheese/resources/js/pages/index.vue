<template>
  <form @submit.prevent="checkAuthKey">
    <validationMessages :errors="validationMessages" />
    <div class="form-group">
      <label for="key">認証キー</label>
      <input
        type="text"
        class="form-control"
        id="key"
        placeholder="認証キーを入力してください"
        v-model="authKey"
      />
    </div>
    <button type="submit" class="btn btn-primary">送信</button>
  </form>
</template>

<script>
import api from "../api";
import { mapGetters } from "vuex";
import validationMessages from "../components/validationMessages";

export default {
  components: {
    validationMessages
  },
  data() {
    return {
      authKey: "",
      validationMessages: []
    };
  },
  computed: {
    ...mapGetters({
      isApiSuccess: "status/isApiSuccess"
    }),
  },
  methods: {
    async checkAuthKey() {
    this.delValidation();
      if(this.authKey.trim() === "") {
        this.validationMessages.push("認証キーを入力してください");
        return false
      }
      const response = await api.eventAuth(this.authKey)
      if (this.isApiSuccess) {
        this.$router.push({ path: `/events/event-${response.id}`});
      } else {
        this.validationMessages.push(response)
      }
    },
    delValidation() {
      this.validationMessages = [];
    }
  }
}
</script>

<style scoped>
</style>
