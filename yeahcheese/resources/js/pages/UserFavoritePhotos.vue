<template>
  <div id="user-favorite-photos" v-if="isLogin">
    <div class="option" :class="isFlex">
      <h2 class="greet-text" :class="isFullWidth">{{ greetText }}</h2>
      <change-columns
        :min="minColumn"
        :max="maxColumn"
        :device="accessDevice"
        :selected="selectedColumns"
      ></change-columns>
    </div>
    <photo-list :photos="favoritePhotos || []" :event="event" />
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import photoList from "../components/PhotoList";
import ChangeColumns from "../components/ChangeColumns";
export default {
  name: "UserFavoritePhotos",
  components: {
    photoList,
    ChangeColumns
  },
  data() {
    return {
      event: {}
    };
  },
  computed: {
    ...mapGetters({
      isMyEventByEventId: "events/isMyEventByEventId",
      getPhotosForEventId: "photos/getPhotosForEventId",
      user: "users/user",
      isLogin: "users/isLogin",
      favoritePhotos: "photos/userFavoritePhotos",
      selectedColumns: "display/selectedColumns",
      accessDevice: "display/accessDevice"
    }),
    greetText() {
      return this.user.name + "さんのお気に入りの写真一覧";
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
    ...mapActions("photos", ["photoLikesIndex"])
  },
  created() {
    this.photoLikesIndex();
  }
};
</script>

<style scoped>
.greet-text {
  color: rgba(20, 20, 20, 0.7);
  text-align: center;
  padding: 0 16px;
}
.d-flex.option * {
  padding: 0 16px;
}
h2.is-full-width {
  text-align: center;
}
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
