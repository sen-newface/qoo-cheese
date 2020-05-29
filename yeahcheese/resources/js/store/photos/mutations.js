import * as types from '../mutation-types';
import Vue from "vue"

export default {
  setEventPhotos(state, photos) {
    state.eventPhotos.push(photos)//photos は{event_id: 2, photods: []}みたいなやつ
  },
  addPhotosByEventId(state, { event_id, photos }) {
    if (!state.eventPhotos.find(event => Number(event.event_id) == event_id)) return false
    let event_photos = photos.concat(state.eventPhotos.find(event => Number(event.event_id) == event_id).photos)
    state.eventPhotos.find(event => Number(event.event_id) == event_id).photos = event_photos
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

  toggleEventPhotoFavorite(state, { event_id, photo_id, bool }) {
    let event_index = state.eventPhotos.findIndex(event => event.event_id == event_id.toString())
    const event = state.eventPhotos.find(event => event.event_id == event_id.toString())
    if (!event) return false
    let photo_index = event.photos.findIndex(photo => photo.id == photo_id);
    state.eventPhotos[event_index].photos[photo_index].is_favorite = bool
  },
  pushLikedPhoto(state, photo) {
    const pushIdx = state.likedPhotos.length;
    state.likedPhotos.splice(pushIdx, 1, photo);
    state.eventPhotos.forEach((eventInfo) => {
      if (eventInfo.photos.includes(photo.id)) {
        console.log('このイベント', eventInfo);
        const idx = eventInfo.photos.findIndex((p) => p.id === photo.id);
        Vue.set(eventInfo.photos[idx], 'is_favorite', true);
      }
    });
  },
  deleteLikedPhoto(state, photo) {
    //eventPhotosとlikedPhotosを変更
    const index = state.likedPhotos.findIndex((p) => {
      return p.id == photo.id;
    });
    state.likedPhotos.splice(index, 1);
    state.eventPhotos.forEach((eventInfo) => {
      if (eventInfo.photos.includes(photo.id)) {
        console.log('このイベント', eventInfo);
        const idx = eventInfo.photos.findIndex((p) => p.id === photo.id);
        Vue.set(eventInfo.photos[idx], 'is_favorite', false);
      }
    });
  }
}
