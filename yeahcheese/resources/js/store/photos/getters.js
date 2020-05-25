const getters = {
  getPhotosForEvnetId: state => (id) => {
    const obj = state.eventPhotos.find(event => event.event_id == id.toString())
    return obj ? obj.photos : null
  },
  getNumberOfPhotosForEventId: (state, getters, rootState) => (id) => {
    const events = rootState.events.events;
    const event = events.filter(event => event.id == id.toString())[0];
    return event.photos_count;
  }
}
export default getters
