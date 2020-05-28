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
  },
  deleteLikedPhoto(state, disLikePhoto) {
    const index = state.likedPhotos.findIndex((photo) => {
      return photo.id = disLikePhoto.id;
    });
    state.likedPhotos.splice(index, 1);
  }
}
