import * as types from '../mutation-types';
import Vue from "vue"

export default {
  setEventPhotos(state, photos) {
    state.eventPhotos.push(photos)//photos は{event_id: 2, photods: []}みたいなやつ
  },
  addPhotoByEventId(state, { event_id, photo }) {
    if (!state.eventPhotos.find(event => Number(event.event_id) == event_id)) return false
    state.eventPhotos.find(event => Number(event.event_id) == event_id).photos.unshift(photo)
  },
  delPhotoByEventId(state, { event_id, photo_index }) {
    if (!state.eventPhotos.find(event => parseInt(event.event_id) == parseInt(event_id))) return false
    Vue.delete(state.eventPhotos.find(event => parseInt(event.event_id) == parseInt(event_id)).photos, photo_index)
  },
  delPhotos(state) {
    state.eventPhotos = []
  },

  setLikedPhotos(state, likePhotos) {
    state.likedPhotos = likePhotos;
  },
  pushLikedPhoto(state, likePhoto) {
    state.likedPhotos.push(likePhoto);
    state.eventPhotos.forEach((eventInfo) => {
      console.log(eventInfo);
      if (eventInfo.photos.includes(likePhoto.photo_id)) {
        const idx = eventInfo.photos.findIndex((p) => p.id === likePhoto.photo_id);
        eventInfo.photos[idx].is_favorite = true;
      }
    });
  },
  deleteLikedPhoto(state, dislikePhoto) {
    //eventPhotosとlikedPhotosを変更
    const index = state.likedPhotos.findIndex((photo) => {
      return photo.id = dislikePhoto.id;
    });
    state.likedPhotos.splice(index, 1);
    state.eventPhotos.forEach((eventInfo) => {
      if (eventInfo.photos.includes(dislikePhoto.photo_id)) {
        const idx = eventInfo.photos.findIndex((p) => p.id === likePhoto.photo_id);
        eventInfo.photos[idx].is_favorite = false;
      }
    });
  }
}
