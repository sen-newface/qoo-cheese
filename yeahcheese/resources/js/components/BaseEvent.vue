<template>
  <div class="card mb-3">
    <div class="card-header">
      <h3 class="float-left">{{ eventInfo.name }}</h3>
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
</style>
