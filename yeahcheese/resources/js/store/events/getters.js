
import store from '../../store'
const getters = {
  events: state => state.events.slice().sort(function (a, b) { return (a.id < b.id ? 1 : -1) }),
  last_page: (state, getters) => {
    let page = Math.floor(state.events.length / getters.page_per_events);
    let add = state.events.length % getters.page_per_events;
    return add ? page + 1 : page
  },
  page_per_events: state => state.page_per_events,
  curretEventPage: state => state.curretEventPage,
  initLoad: state => state.initLoad,
  getEventsForPageId: (state, getters) => (page = 1) => {
    let end_index = getters.page_per_events * page
    let start_index = end_index - getters.page_per_events
    return state.events.slice(start_index, end_index)
  },
  getEventForId: state => (id) => {
    return state.events.find(event => event.id == id)
  },
  isMyEventByEventId: (state, getters) => (event_id) => {
    let user = store.getters["users/user"];
    if (!user.name) return false;
    var target = getters.getEventForId(event_id);
    if (target && target.user_id == user.id) return true;
    return false;
  },
}

export default getters
