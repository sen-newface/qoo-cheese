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
      changeSort: true,
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
      events: "events/events"
    }),
    showEvents() {
      const vue = this;
      let results = [];
      results = this.events.filter(function(item) {
        return item.name.indexOf(vue.searchText) >= 0;
      });
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
  }
};
</script>
