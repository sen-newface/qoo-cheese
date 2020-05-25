<template>
  <article>
    <router-link v-if="isLogin" class="btn btn-outline-info mb-5" :to="{ path: '/events/'}">一覧へ戻る</router-link>
    <router-link v-else class="btn btn-outline-info mb-5" :to="{ path: '/'}">TOPへ</router-link>
    <div class="card text-center mb-5">
      <div class="card-header">{{event.name}}</div>
      <div class="card-body" v-if="isMyEventByEventId(event.id)">
        <p class="card-text">認証キー： {{event.key}}</p>
        <a href="#" class="btn btn-primary">編集</a>
        <button type="button" class="btn btn-danger">削除</button>
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
        <change-columns
          :min="minColumn"
          :max="maxColumn"
          :device="accessDevice"
          :selected="selectedColumns"
        ></change-columns>
      </div>
      <div id="img-thumbnail" class="d-flex align-items-start flex-wrap mb-5 img-area">
        <img
          v-show="getPhotosForEventId(event.id) && getPhotosForEventId(event.id).length"
          v-for=" image in getPhotosForEventId(event.id)"
          :key="image.id"
          :alt="alt(image.id)"
          :src="image.image_path"
          class="img-thumbnail"
          :class="imgThumbnailSize"
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
import ChangeColumns from "../components/ChangeColumns";
export default {
  components: {
    ChangeColumns
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
      getPhotosForEventId: "photos/getPhotosForEvnetId",
      isLogin: "users/isLogin",
      selectedColumns: "display/selectedColumns",
      accessDevice: "display/accessDevice"
    }),
    alt() {
      return function(id) {
        return this.event.name + "の写真" + id;
      };
    },
    minColumn() {
      // * accessDeviceがtrueのときはPCからのアクセス
      // * PCの場合は最小列数は2
      const min = this.accessDevice ? 2 : 1;
      return min;
    },
    maxColumn() {
      // * accessDeviceがtrueのときはPCからのアクセス
      // * PCの場合は最大列数は5
      const max = this.accessDevice ? 5 : 2;
      return max;
    },
    imgThumbnailSize() {
      return "img-thumbnail-size" + this.selectedColumns;
    }
  },
  methods: {
    ...mapActions("display", ["getAccessingUserDevice"])
  },
  async created() {
    let event_id = this.$route.params["id"];
    await this.$store.dispatch("events/getEventsAndPhotosIfNotExits", event_id);
    this.event = this.getEventForId(event_id);
    this.getAccessingUserDevice();
  }
};
</script>


<style scoped>
.img-area img {
  transition: 0.5s;
}
.img-area * {
  transition: max-width 0.2s ease;
}
#img-thumbnail.img-area .img-thumbnail-size1 {
  max-width: 100%;
}
#img-thumbnail.img-area .img-thumbnail-size2 {
  max-width: 48%;
}
#img-thumbnail.img-area .img-thumbnail-size3 {
  max-width: 33%;
}
#img-thumbnail.img-area .img-thumbnail-size4 {
  max-width: 24%;
}
#img-thumbnail.img-area .img-thumbnail-size5 {
  max-width: 19%;
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
