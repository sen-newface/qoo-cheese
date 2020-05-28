import * as types from '../mutation-types';
import Vue from 'vue'

export default {
  setEvents(state, events) {
    state.events = state.events.concat(events);
  },

  replaceEvents(state, events) {
    state.events = events
  },

  setBaseEvents(state, events) {
    state.base_events = events
  },

  setAuthedEvents(state, events) {
    state.authedEvents = state.authedEvents.concat(events);
  },

  setAuthedEvent(state, event) {
    state.authedEvents.unshift(event);
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
  updateEventPreviews(state, { event_id, photos }) {
    const targetIdx = state.events.findIndex((e) => e.id == event_id);
    state.events[targetIdx].photos = photos.slice(0, 2)
  },
  setNowEvent(state, event) {
    state.event = event;
  },
  delEvents(state) {
    state.events = []
  },
  sortByCreated(state, isOrderByAsc) {
    state.events.sort(function (a, b) {
      if (isOrderByAsc) {
        return a.created_at > b.created_at ? 1 : -1;
      }
      return a.created_at < b.created_at ? 1 : -1;
    });
  },
  sortByName(state, isOrderByAsc) {
    state.events.sort(function (a, b) {
      if (isOrderByAsc) {
        return a.name > b.name ? 1 : -1;
      }
      return a.name < b.name ? 1 : -1;
    });
  },
  sortByStartDate(state, isOrderByAsc) {
    state.events.sort(function (a, b) {
      if (isOrderByAsc) {
        return a.start_date > b.start_date ? 1 : -1;
      }
      return a.start_date < b.start_date ? 1 : -1;
    });
  },
  deleteEventForId(state, id) {
    Vue.delete(state.events, state.events.findIndex((e) => e.id == id))
  }
}
