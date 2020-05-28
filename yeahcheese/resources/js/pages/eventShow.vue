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
      <div
        class="card-footer text-muted"
      >{{ dispTransformDeadline(event.start_date, event.end_date) }}</div>
    </div>
    <section>
      <div class="option" :class="isFlex">
        <h3 :class="isFullWidth">写真一覧</h3>
        <PreviewAndSavePhoto v-if="isMyEventByEventId(event.id)" :event-id="event.id" />

        <change-columns
          :min="minColumn"
          :max="maxColumn"
          :device="accessDevice"
          :selected="selectedColumns"
        ></change-columns>
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
import { mapActions, mapGetters } from "vuex";
import PreviewAndSavePhoto from "../components/PreviewAndSavePhoto";
import photoList from "../components/PhotoList";
import ChangeColumns from "../components/ChangeColumns";
export default {
  components: {
    photoList,
    PreviewAndSavePhoto,
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
  methods: {
    ...mapActions("display", ["getAccessingUserDevice"]),
    deleteEvent: async function() {
      var result = confirm("本当にイベントを削除してよろしいですか？");
      if (result) {
        await this.$store.dispatch("events/deleteEvent", this.event.id);
        this.$router.push({ path: "/events" });
      }
    }
  },
  computed: {
    ...mapGetters({
      getEventForId: "events/getEventForId",
      events: "events/events",
      isMyEventByEventId: "events/isMyEventByEventId",
      getPhotosForEventId: "photos/getPhotosForEventId",
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
    isFullWidth() {
      // * accessDeviceがtrueのときはPCからのアクセス
      // * スマホの場合は横幅をフルで取る
      return this.accessDevice ? "ml-4 mr-4" : "is-full-width";
    },
    isFlex() {
      // * accessDeviceがtrueのときはPCからのアクセス
      // * スマホの場合はフレックス対応でないようにする
      return this.accessDevice ? "d-flex mb-2" : "";
    }
  },
  methods: {
    ...mapActions("photos", ["deleteEventPhoto"]),
    async deletePhoto(event_id, photo_id) {
      await this.deleteEventPhoto({ event_id, photo_id });
    },
    deleteEvent: async function() {
      var result = confirm("本当にイベントを削除してよろしいですか？");
      if (result) {
        await this.$store.dispatch("events/deleteEvent", this.event.id);
        this.$router.push({ path: "/events" });
      }
    },
    dispTransformDeadline(release_start, release_end) {
      return;
      this.transformDate(release_start) +
        "〜" +
        this.transformDate(release_end);
    },
    transformDate(date) {
      const dateArr = date.split("-");
      if (dateArr.length === 3) {
        const jaDate =
          dateArr[0] + "年" + dateArr[1] + "月" + dateArr[2] + "日";
        return jaDate;
      } else {
        return date;
      }
    }
  },
  async created() {
    let event_id = this.$route.params["id"];
    await this.$store.dispatch("events/getEventsAndPhotosIfNotExits", event_id);
    this.event = this.getEventForId(event_id);
    // this.getAccessingUserDevice();
    this.$store.dispatch("display/getAccessingUserDevice");
  }
};
</script>

<style scoped>
.d-flex.option * {
  padding: 0 16px;
}
h3.is-full-width {
  text-align: center;
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

<style>
.is-full-width {
  display: block;
  width: 100%;
  margin: 16px 0;
  padding: 32px;
}
.is-full-width * {
  margin-left: 0;
}
</style>
