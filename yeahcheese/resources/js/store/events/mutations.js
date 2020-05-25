import * as types from '../mutation-types';

export default {
  setEvents(state, events) {
    state.events = events
  },
  setInitLoad(state, bool) {
    state.initLoad = bool
  },
  resetEvent(state) {
    state.events = []
    state.initLoad = true
  },
  setEvent(state, event) {
    state.events.push(event)
  },
  setEventPreview(state, { id, photo }) {
    if (!state.events.find(event => Number(event.id) == id) || state.events.find(event => Number(event.id) == id).photos.length >= 2) return false
    state.events.find(event => Number(event.id) == id).photos.push(photo)
  },
  updateEvent(state, event) {
    const targetIdx = state.events.findIndex((e) => e.id == event.id);
    state.events.splice(targetIdx, 1, event);
  },
  setNowEvent(state, event) {
    state.event = event;
  },
  delEvents(state) {
    state.events = []
  }
}
