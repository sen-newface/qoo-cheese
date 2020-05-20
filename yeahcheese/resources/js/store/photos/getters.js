const getters = {
  getPhotosForEvnetId: state => (id) => {
    const obj = state.eventPhotos.find(event => event.event_id == id.toString())
    return obj ? obj.photos : null
  },

}
export default getters
