import * as types from '../mutation-types';

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
  }
}
