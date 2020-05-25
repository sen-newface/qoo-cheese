const getters = {
  getPhotosForEvnetId: state => (id) => {
    const obj = state.eventPhotos.find(event => event.event_id == id.toString())
    return obj ? obj.photos : null
  },

  getPhotoIndexForEvnetId: state => (id, photo_id) => {
    const obj = state.eventPhotos.find(event => event.event_id == id.toString())
    return obj.photos.findIndex(photo => photo.id == photo_id);
  }
}
export default getters
