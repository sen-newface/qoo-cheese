<template>
  <article>
    <router-link v-if="isLogin" class="btn btn-outline-info mb-5" :to="{ path: '/events/'}">一覧へ戻る</router-link>
    <router-link v-else class="btn btn-outline-info mb-5" :to="{ path: '/'}">TOPへ</router-link>
    <div class="card text-center mb-5">
      <div class="card-header">{{event.name}}</div>
      <div class="card-body" v-if="isMyEventByEventId(event.id)">
        <p class="card-text">認証キー： {{event.key}}</p>
        <a href="#" class="btn btn-primary">編集</a>
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
      <div class="d-flex align-items-start flex-wrap mb-5 img-area">
        <img
          v-show="getPhotosForEventId(event.id) && getPhotosForEventId(event.id).length"
          v-for=" image in getPhotosForEventId(event.id)"
          :key="image.id"
          :alt="alt(image.id)"
          :src="image.image_path"
          class="img-thumbnail"
          @click="deletePhoto(event.id, image.id)"
        />
        <p
          v-show="getPhotosForEventId(event.id) && !getPhotosForEventId(event.id).length"
        >写真はまだありません</p>
      </div>
    </section>
  </article>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
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
    }),
    alt() {
      return function(id) {
        return this.event.name + "の写真" + id;
      };
    }
  },
  methods: {
    ...mapActions("photos", ["deleteEventPhoto"]),
    async deletePhoto(event_id, photo_id) {
      await this.deleteEventPhoto({ event_id, photo_id });
    }
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


<style scoped>
.img-area img {
  max-width: 48%;
}
@media screen and (max-width: 767px) {
  .img-area {
    display: block !important;
  }
  .img-area img {
    max-width: 100%;
  }
}
</style>
