<template>
  <div>
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
    <event-list
      v-show="authedEvents.length"
      v-for="event in authedEvents"
      class="mt-4"
      :key="event.key"
      :eventInfo="event"
    ></event-list>
  </div>
</template>

<script>
import api from "../api";
import { mapGetters } from "vuex";
import validationMessages from "../components/validationMessages";
import eventList from "../components/BaseEvent";

export default {
  components: {
    validationMessages,
    eventList
  },
  data() {
    return {
      authKey: "",
      validationMessages: []
    };
  },
  computed: {
    ...mapGetters({
      isApiSuccess: "status/isApiSuccess",
      getEventForkey: "events/getEventForkey",
      authedEvents: "events/authedEvents"
    })
  },
  methods: {
    async checkAuthKey() {
      this.delValidation();
      if (this.authKey.trim() === "") {
        this.validationMessages.push("認証キーを入力してください");
        return false;
      }
      let response = await api.eventAuth(this.authKey);
      if (this.isApiSuccess) {
        this.$router.push({ path: response.path });
      } else {
        this.validationMessages.push(...response.errors);
      }
      let event = this.getEventForkey(this.authKey);
      if (event) {
        this.$router.push({ path: `/events/event-${event.id}` });
        return false;
      }
    },
    delValidation() {
      this.validationMessages = [];
    }
  }
};
</script>

<style scoped>
</style>
