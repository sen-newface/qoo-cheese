<template>
  <div>
    <div class="md-form active-cyan-2 mb-3">
      <input
        class="form-control"
        type="text"
        v-model="searchText"
        placeholder="イベント検索"
        aria-label="イベント検索"
      />
    </div>
    <router-link class="btn btn-outline-info mb-5" :to="{ path: '/events/new'}">新規作成</router-link>
    <event-list
      v-show="showEvents.length"
      v-for="event in showEvents"
      :key="event.key"
      :eventInfo="event"
    ></event-list>
    <p v-show="!showEvents.length && !searchText">イベントは一つも登録されていません。</p>
    <p v-show="!showEvents.length && searchText">ヒットしませんでした</p>
  </div>
</template>

<script>
import eventList from "../components/BaseEvent";
import { mapGetters } from "vuex";
export default {
  components: { eventList },
  data() {
    return {
      searchText: ""
    };
  },
  computed: {
    ...mapGetters({
      events: "events/events"
    }),
    showEvents() {
      const vue = this;
      let results = [];
      return (results = this.events.filter(function(item) {
        return item.name.indexOf(vue.searchText) >= 0;
      }));
    }
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
  }
};
</script>
