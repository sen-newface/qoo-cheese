<template>
  <div>
    <router-link class="btn btn-outline-info mb-5" :to="{ path: '/events/new'}">新規作成</router-link>
    <event-list v-show="events.length" v-for="event in events" :key="event.key" :eventInfo="event"></event-list>
    <p v-show="!events.length">イベントは一つも登録されていません。</p>
  </div>
</template>

<script>
import eventList from "../components/BaseEvent";
import { mapGetters } from "vuex";
export default {
  components: { eventList },
  computed: {
    ...mapGetters({
      events: "events/events"
    })
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
  }
};
</script>
