import * as types from '../mutation-types';
import Vue from 'vue'

export default {
  setEvents(state, events) {
    state.events = state.events.concat(events);
  },

  setcurrentEventPage(state, page) {
    state.currentEventPage = parseInt(page)
  },
  setNumberOfPage(state, num) {
    state.events_per_page = num
  },

  setInitLoad(state, bool) {
    state.initLoad = bool
  },

  resetEvent(state) {
    state.events = []
    state.initLoad = true
    state.last_page = 1
    state.currentEventPage = 1
  },
  setEvent(state, event) {
    state.events.unshift(event)
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
  },
  deleteEventForId(state, id) {
    Vue.delete(state.events, state.events.findIndex((e) => e.id == id))
  }
}
