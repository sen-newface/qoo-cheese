import * as types from '../mutation-types';

export default {
  setEventPhotos(state, photos) {
    state.eventPhotos.push(photos)//photos は{event_id: 2, photods: []}みたいなやつ
  },
  addPhotoByEventId(state, { event_id, photo }) {
    if (!state.eventPhotos.find(event => Number(event.event_id) == event_id)) return false
    state.eventPhotos.find(event => Number(event.event_id) == event_id).photos.unshift(photo)
  },
  delPhotos(state) {
    state.eventPhotos = []
  }
}
