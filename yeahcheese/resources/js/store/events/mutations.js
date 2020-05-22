import * as types from '../mutation-types';

export default {
  setEvents(state, events) {
    state.events = state.events.concat(events);
  },

  setCurretEventPage(state, page) {
    state.curretEventPage = parseInt(page)
  },
  setNumberOfPage(state, num) {
    state.page_per_events = num
  },

  setInitLoad(state, bool) {
    state.initLoad = bool
  },

  resetEvent(state) {
    state.events = []
    state.initLoad = true
    state.last_page = 1
    state.curretEventPage = 1
  },
  setEvent(state, event) {
    state.events.unshift(event)
  },
  delEvents(state) {
    state.events = []
  },
}
