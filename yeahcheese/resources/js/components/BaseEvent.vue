<template>
  <div class="card mb-3">
    <div class="card-header">
      <h3 class="float-left d-flex align-items-center">
        {{ eventInfo.name }}
        <span
          class="badge"
          :class="getLabelByDeadline(strDel(eventInfo.start_date), strDel(eventInfo.end_date)).class"
        >{{ getLabelByDeadline(strDel(eventInfo.start_date), strDel(eventInfo.end_date)).text }}</span>
      </h3>
      <router-link
        class="btn btn-outline-primary float-right"
        :to="{ name: 'eventShow', params: { id: eventInfo.id } }"
      >詳細へ</router-link>
    </div>
    <div class="row">
      <div class="col-md">
        <div class="card-body">
          <h5 class="card-title">{{ eventInfo.start_date }} - {{ eventInfo.end_date }}</h5>
          <p class="card-text">認証キー：{{ eventInfo.key }}</p>
        </div>
      </div>
      <div class="col-md">
        <img
          v-for="photo in eventInfo.photos"
          :key="photo.id"
          :src="photo.image_path"
          style="max-width: 200px"
          class="img-thumbnail float-right"
          :alt="alt(photo.id)"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseEvent",
  props: {
    eventInfo: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    alt() {
      return function(id) {
        return this.eventInfo.name + "の写真" + id;
      };
    },
    // イベントの公開開始日と終了日を取得し、公開開始前、開始後、終了後でラベルを変更させる
    getLabelByDeadline() {
      return function(start_date, end_date) {
        let today = this.getToday();
        // 公開開始前
        if (today < parseInt(start_date)) {
          return { class: "badge-secondary", text: "公開前" };
        }
        // 公開終了後
        if (parseInt(end_date) < today) {
          return { class: "badge-danger", text: "公開終了" };
        }
        // 公開中
        return { class: "badge-success", text: "公開中" };
      };
    }
  },
  methods: {
    getToday() {
      let now = new Date();
      let y = now.getFullYear();
      let m = now.getMonth() + 1;
      let d = now.getDate();
      if (m < 10) {
        m = "0" + m;
      }
      if (d < 10) {
        d = "0" + d;
      }
      return y + m + d;
    },
    // イベントのstart_dateとend_dateのハイフンを消す
    strDel(str) {
      let res = str.slice(0, 4) + str.slice(5, 7) + str.slice(8);
      return res;
    }
  }
};
</script>

<style scoped>
@media screen and (max-width: 767px) {
  img {
    float: none !important;
  }
}

h3 span {
  font-size: 14px;
}
</style>
