<template>
  <article>
    <router-link v-if="isLogin" class="btn btn-outline-info mb-5" :to="{ path: '/events/'}">一覧へ戻る</router-link>
    <router-link v-else class="btn btn-outline-info mb-5" :to="{ path: '/'}">TOPへ</router-link>
    <div class="card text-center mb-5">
      <div class="card-header">{{event.name}}</div>
      <div class="card-body" v-if="isMyEventByEventId(event.id)">
        <p class="card-text">認証キー： {{event.key}}</p>
        <router-link class="btn btn-primary" :to="{ name: 'eventEdit', params:  {id: event.id} }">編集</router-link>
        <button type="button" class="btn btn-danger" @click="deleteEvent">削除</button>
      </div>
      <div class="card-footer text-muted">{{ event.start_date }} - {{ event.end_date }}</div>
    </div>
    <section>
      <div class="d-flex mb-2">
        <h3>写真一覧</h3>
        <button
          v-if="isMyEventByEventId(event.id)"
          type="button"
          class="btn btn-outline-success ml-4"
        >写真追加</button>
      </div>
      <photo-list
        :photos="getPhotosForEventId(event.id) || []"
        :event="this.event"
        :isMyEvent="isMyEventByEventId(event.id)"
      />
    </section>
  </article>
</template>

<script>
import { mapGetters } from "vuex";
import photoList from "../components/PhotoList";
export default {
  components: {
    photoList
  },
  data() {
    return {
      event: {
        id: 0,
        name: "",
        key: "",
        start_date: "",
        end_date: ""
      }
    };
  },
  computed: {
    ...mapGetters({
      getEventForId: "events/getEventForId",
      events: "events/events",
      isMyEventByEventId: "events/isMyEventByEventId",
      getPhotosForEventId: "photos/getPhotosForEventId",
      isLogin: "users/isLogin"
    })
  },
  async created() {
    let event_id = this.$route.params["id"];
    await this.$store.dispatch("events/getEventsAndPhotosIfNotExits", event_id);
    this.event = this.getEventForId(event_id);
  },
  methods: {
    deleteEvent: async function() {
      var result = confirm("本当にイベントを削除してよろしいですか？");
      if (result) {
        await this.$store.dispatch("events/deleteEvent", this.event.id);
        this.$router.push({ path: "/events" });
      }
    }
  }
};
</script>
