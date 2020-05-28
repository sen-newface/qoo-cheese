<template>
  <div id="user-favorite-photos" v-if="isLogin">
    <photo-list
      :photos="getPhotosForEventId(event.id) || []"
      :event="this.event"
      :isMyEvent="isMyEventByEventId(event.id)"
    />
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import photoList from "../components/PhotoList";
export default {
  name: "UserFavoritePhotos",
  components: {
    photoList
  },
  computed: {
    ...mapGetters({
      isMyEventByEventId: "events/isMyEventByEventId",
      getPhotosForEventId: "photos/getPhotosForEventId",
      isLogin: "users/isLogin",
      favoritePhotos: "photos/userFavoritePhotos"
    })
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
</style>
