<template>
  <div>
    <router-link class="btn btn-outline-info mb-5" :to="{ path: '/events/new'}">新規作成</router-link>
    <event-list v-for="event in events" :key="event.key" :eventInfo="event"></event-list>
  </div>
</template>

<script>
import eventList from "../components/BaseEvent";
import { mapGetters } from "vuex";
export default {
  components: { eventList },
  data() {
    return {
      events: this.vuex_events
    };
  },
  computed: {
    ...mapGetters({
      vuex_events: "events/events"
    })
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
    this.events = this.vuex_events;
  }
};
</script>
