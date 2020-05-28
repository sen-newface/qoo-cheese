<template>
  <div>
    <router-link class="btn btn-outline-info mb-3" :to="{ path: '/events/new'}">新規作成</router-link>
    <div class="md-form active-cyan-2 mb-3">
      <input
        class="form-control"
        type="text"
        v-model="searchText"
        placeholder="イベント検索"
        aria-label="イベント検索"
      />
    </div>
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
          v-if="isOrderByAsc"
          class="btn btn-outline-secondary"
          type="button"
          @click="changeOrderBy"
        >昇順</button>
        <button v-else class="btn btn-outline-secondary" type="button" @click="changeOrderBy">降順</button>
      </div>
      <select
        class="custom-select"
        id="inputGroupSelect03"
        v-model="selected"
        @change="changeSortBy"
      >
        <option v-for="op in options" :key="op.text" :value="op.const">{{ op.text }}</option>
      </select>
    </div>
    <event-list
      v-show="showEvents.length"
      v-for="event in showEvents"
      :key="event.key"
      :eventInfo="event"
    ></event-list>
    <pagenation v-if="showEvents.length" />
    <p v-show="!showEvents.length && !searchText">イベントは一つも登録されていません。</p>
    <p v-show="!showEvents.length && searchText">ヒットしませんでした</p>
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
      searchText: "",
      page: this.$route.query.page || 1,
      numberOfPage: this.events_per_page,
      numberOfPageList: [3, 5, 10],
      isOrderByAsc: false,
      selected: "CREATED_AT",
      options: [
        { text: "イベント作成順(既定)", const: "CREATED_AT" },
        { text: "イベント名順", const: "NAME" },
        { text: "公開開始日順", const: "START_DATE" }
      ],
      base_events: []
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
      let base_events = this.base_events;
      let st = this.searchText;
      let res = [];
      if (st) {
        res = this.events.filter(item => {
          return item.name.indexOf(st) >= 0;
        });
        this.$store.commit("events/replaceEvents", res);
        if (this.events.length && !this.getEventsForPageId(this.page).length) {
          this.$router.push({ path: "/events", query: { page: 1 } });
        }
      } else {
        if (base_events.length) {
          this.$store.commit("events/replaceEvents", base_events);
        }
      }

      return this.getEventsForPageId(this.page);
    }
  },
  methods: {
    changeSortBy() {
      switch (this.selected) {
        case "CREATED_AT":
          this.$store.commit("events/sortByCreated", this.isOrderByAsc);
          break;
        case "NAME":
          this.$store.commit("events/sortByName", this.isOrderByAsc);
          break;
        case "START_DATE":
          this.$store.commit("events/sortByStartDate", this.isOrderByAsc);
          break;
        default:
          this.searchedEvents;
          break;
      }
    },
    changeOrderBy() {
      this.isOrderByAsc = !this.isOrderByAsc;
      this.changeSortBy();
    }
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
    this.numberOfPage = this.events_per_page;
    this.$store.commit("events/sortByCreated", this.isOrderByAsc);
    this.base_events = this.events;
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
