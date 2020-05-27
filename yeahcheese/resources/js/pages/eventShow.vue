<template>
  <article>
    <router-link v-if="isLogin" class="btn btn-outline-info mb-5" :to="{ path: '/events/'}">一覧へ戻る</router-link>
    <router-link v-else class="btn btn-outline-info mb-5" :to="{ path: '/'}">TOPへ</router-link>
    <div class="card text-center mb-5">
      <div class="card-header d-flex align-items-center justify-content-center">
        {{event.name}}
        <span
          class="badge"
          :class="this.getLabelByDeadline(event.start_date, event.end_date).class"
        >{{ this.getLabelByDeadline(event.start_date, event.end_date).text }}</span>
      </div>
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
        <PreviewAndSavePhoto v-if="isMyEventByEventId(event.id)" :event-id="event.id" />
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
import PreviewAndSavePhoto from "../components/PreviewAndSavePhoto";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    PreviewAndSavePhoto
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
      isLogin: "users/isLogin",
      getLabelByDeadline: "events/getLabelByDeadline"
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


<style scoped lang="scss">
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
.badge {
  font-size: 12px;
  margin-left: 6px;
}
</style>
