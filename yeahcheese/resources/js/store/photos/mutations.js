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
  }
}
