<template>
  <div class="card mb-3">
    <div class="card-header">
      <h3 class="float-left d-flex align-items-center">
        {{ eventInfo.name }}
        <span
          class="badge"
          :class="this.getLabelByDeadline(eventInfo.start_date, eventInfo.end_date).class"
        >{{ this.getLabelByDeadline(eventInfo.start_date, eventInfo.end_date).text }}</span>
      </h3>
      <router-link
        class="btn btn-outline-primary float-right"
        :to="{ name: 'eventShow', params: { id: eventInfo.id } }"
      >詳細へ</router-link>
    </div>
    <div class="row">
      <div class="col-md">
        <div class="card-body">
          <h5
            class="card-title"
          >{{ dispTransformDeadline(eventInfo.start_date, eventInfo.end_date) }}</h5>
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
    <p class="photo-count">( 写真の枚数：{{ eventInfo.photos_count }} )</p>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "BaseEvent",
  props: {
    eventInfo: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    ...mapGetters({
      getLabelByDeadline: "events/getLabelByDeadline"
    }),
    alt() {
      return function(id) {
        return this.eventInfo.name + "の写真" + id;
      };
    }
  },
  methods: {
    dispTransformDeadline(release_start, release_end) {
      return (
        this.transformDate(release_start) +
        "〜" +
        this.transformDate(release_end)
      );
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
  }
};
</script>

<style scoped>
.photo-count {
  text-align: right;
  padding: 8px 16px 0;
}
@media screen and (max-width: 767px) {
  img {
    float: none !important;
  }
}

h3 span {
  font-size: 14px;
  margin-left: 12px;
}
</style>
