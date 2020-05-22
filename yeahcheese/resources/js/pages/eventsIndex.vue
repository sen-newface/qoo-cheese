<template>
  <div>
    <router-link class="btn btn-outline-info mb-3" :to="{ path: '/events/new'}">新規作成</router-link>
    <section class="mb-2">
      <p>1ページあたりの表示件数</p>
      <div class="d-flex">
        <div class="form-check mr-3" v-for="num in numberOfPageList" :key="num">
          <input
            class="form-check-input"
            type="radio"
            name="exampleRadios"
            :id="'page-num' + num"
            :value="num"
            v-model="numberOfPage"
          />
          <label class="form-check-label" :for="'page-num' + num">{{num}}件</label>
        </div>
      </div>
    </section>
    <event-list
      v-show="showEvents.length"
      v-for="event in showEvents"
      :key="event.key"
      :eventInfo="event"
    ></event-list>
    <p v-show="!events.length">イベントは一つも登録されていません。</p>
    <pagenation v-show="events.length" />
  </div>
</template>

<script>
import eventList from "../components/BaseEvent";
import pagenation from "../components/Pagenation";
import { mapGetters } from "vuex";
export default {
  components: { eventList, pagenation },
  data() {
    return {
      page: this.$route.query.page || 1,
      numberOfPage: this.page_per_events,
      numberOfPageList: [3, 5, 10]
    };
  },
  computed: {
    ...mapGetters({
      events: "events/events",
      getEventsForPageId: "events/getEventsForPageId",
      curretEventPage: "events/curretEventPage",
      page_per_events: "events/page_per_events"
    }),
    showEvents() {
      let results = this.getEventsForPageId(this.page);
      return results;
    }
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
    this.numberOfPage = this.page_per_events;
  },
  watch: {
    "$route.query.page": {
      handler(val) {
        if (val) {
          this.$store.commit("events/setCurretEventPage", val);
        }
        const page = this.curretEventPage;
        this.page = page;
        if (this.events.length && !this.getEventsForPageId(page).length) {
          this.$router.push({ path: "/events", query: { page: 1 } });
        }
      },
      immediate: true
    },
    numberOfPage: function(val) {
      this.$store.commit("events/setNumberOfPage", val);
      if (this.events.length && !this.getEventsForPageId(this.page).length) {
        this.$router.push({ path: "/events", query: { page: 1 } });
      }
    }
  }
};
</script>
