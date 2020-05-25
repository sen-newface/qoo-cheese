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
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <button
          v-if="changeSort"
          class="btn btn-outline-secondary"
          type="button"
          @click="changeSortText"
        >昇順</button>
        <button v-else class="btn btn-outline-secondary" type="button" @click="changeSortText">降順</button>
      </div>
      <select class="custom-select" id="inputGroupSelect03" v-model="selected">
        <option v-for="op in options" :key="op.text" :value="op.const">{{ op.text }}</option>
      </select>
    </div>
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
      numberOfPage: this.events_per_page,
      numberOfPageList: [3, 5, 10],
      changeSort: false,
      selected: "CREATE_AT",
      options: [
        { text: "イベント作成順(既定)", const: "CREATE_AT" },
        { text: "イベント名順", const: "NAME" },
        { text: "公開開始日順", const: "START_DATE" }
      ]
    };
  },
  computed: {
    ...mapGetters({
      events: "events/events",
      getEventsForPageId: "events/getEventsForPageId",
      currentEventPage: "events/currentEventPage",
      events_per_page: "events/events_per_page"
    }),
    showEvents() {
      const vue = this;
      let results = this.getEventsForPageId(this.page);
      switch (this.selected) {
        case "CREATE_AT":
          return (results = this.events.slice().sort(function(a, b) {
            if (vue.changeSort) {
              return a.created_at > b.created_at ? 1 : -1;
            }
            return a.created_at < b.created_at ? 1 : -1;
          }));
          break;
        case "NAME":
          return (results = this.events.slice().sort(function(a, b) {
            if (vue.changeSort) {
              return a.name > b.name ? 1 : -1;
            }
            return a.name < b.name ? 1 : -1;
          }));
          break;
        case "START_DATE":
          return (results = this.events.slice().sort(function(a, b) {
            if (vue.changeSort) {
              return a.start_date > b.start_date ? 1 : -1;
            }
            return a.start_date < b.start_date ? 1 : -1;
          }));
          break;
        default:
          return this.events;
      }
    }
  },
  methods: {
    changeSortText() {
      this.changeSort = !this.changeSort;
    }
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
    this.numberOfPage = this.events_per_page;
  },
  watch: {
    "$route.query.page": {
      handler(val) {
        if (val) {
          this.$store.commit("events/setcurrentEventPage", val);
        }
        const page = this.currentEventPage;
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
