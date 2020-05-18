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
  }
}
