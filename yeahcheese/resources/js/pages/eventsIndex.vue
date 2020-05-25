<template>
  <div>
    <router-link class="btn btn-outline-info mb-5" :to="{ path: '/events/new'}">新規作成</router-link>
    <event-list
      v-show="events.length"
      v-for="event in events"
      :class="colorClassByDate(event.start_date, event.end_date)"
      :key="event.key"
      :eventInfo="event"
    ></event-list>
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
  methods: {
    colorClassByDate: function(start_date, end_date) {
      let today = this.getToday();
      return {
        "border-color": start_date <= today && today <= end_date,
        "border border-danger": !(start_date <= today && today <= end_date)
      };
    },
    getToday() {
      let now = new Date();
      let y = now.getFullYear();
      let m = now.getMonth() + 1;
      let d = now.getDate();
      if (m < 10) {
        m = "0" + m;
      }
      if (d < 10) {
        d = "0" + d;
      }
      return y + "-" + m + "-" + d;
    }
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
  }
};
</script>
<style scoped>
.border-color {
  border-color: #66ccff;
}
</style>