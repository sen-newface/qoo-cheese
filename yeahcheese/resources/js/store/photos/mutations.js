import * as types from '../mutation-types';

export default {
  setEventPhotos(state, photos) {
    state.eventPhotos.push(photos)//photos は{event_id: 2, photods: []}みたいなやつ
  },
  addPhotoByEventId(state, event_id, photo) {
    if (!state.eventPhotos.find(event => event.id == event_id)) return false
    state.eventPhotos.find(event => event.id == event_id).push(photo)
  },
  delPhotos(state) {
    state.eventPhotos = []
  },
  deleteOnePhoto(state, { event_id, photo_id }) {
    console.log(state.eventPhotos);
    // state.eventPhotos = state.eventPhotos.map((event) => {
    //   if (event.id == event_id) {
    //     console.log('event', event);
    //     //event.photosで取得する
    //   }
    // });
  }
}
