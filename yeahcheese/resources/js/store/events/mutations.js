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

  delEvents(state) {
    state.events = []
  },

  deleteEventForId(state, id) {
    state.events = state.events.filter((v) => v.id !== id);
  }
}
