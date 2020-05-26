import store from '../../store'
const getters = {
  events: state => state.events,
  base_events: state => state.base_events,
  last_page: (state, getters) => {
    let page = Math.floor(state.events.length / getters.events_per_page);
    let add = state.events.length % getters.events_per_page;
    return add ? page + 1 : page
  },
  events_per_page: state => state.events_per_page,
  currentEventPage: state => state.currentEventPage,
  initLoad: state => state.initLoad,
  getEventsForPageId: (state, getters) => (page = 1) => {
    let end_index = getters.events_per_page * page
    let start_index = end_index - getters.events_per_page
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
  }
}
export default getters
