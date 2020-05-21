<template>
  <div>
    <router-link class="btn btn-outline-info mb-5" :to="{ path: '/events/new'}">新規作成</router-link>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <button
          class="btn btn-outline-secondary"
          type="button"
          :value="sortText"
          @click="changeSortText"
        >{{ sortText }}</button>
      </div>
      <select class="custom-select" id="inputGroupSelect03" v-model="selected">
        <option v-for="op in options" :key="op.text" :value="op.num">{{ op.text }}</option>
      </select>
    </div>
    <event-list
      v-show="events.length"
      v-for="event in showEvents"
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
  data() {
    return {
      sortText: "昇順",
      changeSort: false,
      selected: "1",
      options: [
        { text: "イベント作成順(既定)", num: "1" },
        { text: "イベント名順", num: "2" },
        { text: "公開開始日順", num: "3" }
      ]
    };
  },
  computed: {
    ...mapGetters({
      events: "events/events",
      eventsSortById: "events/eventsSortById",
      eventsSortByName: "events/eventsSortByName",
      eventsSortByStartDate: "events/eventsSortByStartDate"
    }),
    showEvents() {
      switch (this.selected) {
        case "1":
          return this.eventsSortById(this.changeSort);
        case "2":
          return this.eventsSortByName(this.changeSort);
        case "3":
          return this.eventsSortByStartDate(this.changeSort);
        default:
          return this.events;
      }
    }
  },
  methods: {
    changeSortText() {
      this.changeSort = !this.changeSort;
      this.sortText === "昇順"
        ? (this.sortText = "降順")
        : (this.sortText = "昇順");
    }
  },
  async created() {
    await this.$store.dispatch("events/initGetEvents");
  }
};
</script>
