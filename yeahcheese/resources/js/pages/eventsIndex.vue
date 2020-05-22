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
      v-show="searchEvents.length"
      v-for="event in searchEvents"
      :key="event.key"
      :eventInfo="event"
    ></event-list>
    <p v-show="!events.length">イベントは一つも登録されていません。</p>
    <p v-show="events.length && !searchEvents.length">ヒットしませんでした</p>
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
      events: "events/events",
      searchEventsByInputText: "events/searchEventsByInputText"
    }),
    searchEvents() {
      return this.searchEventsByInputText(this.searchText);
    }
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
  }
};
</script>
