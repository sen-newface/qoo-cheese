import store from '../../store'
const getters = {
  events: state => state.events,
  base_events: state => state.base_events,
  authedEvents: state => state.authedEvents,
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
    let res = state.events.find(event => event.id == id);
    if (!res) res = state.authedEvents.find(event => event.id == id);
    return res
  },
  getEventForkey: state => (key) => {
    return state.authedEvents.find(event => event.key == key);
  },
  isMyEventByEventId: (state, getters) => (event_id) => {
    let user = store.getters["users/user"];
    if (!user.name) return false;
    var target = getters.getEventForId(event_id);
    if (target && target.user_id == user.id) return true;
    return false;
  },
  getToday: () => {
    let now = new Date();
    let y = now.getFullYear();
    let m = now.getMonth() + 1;
    let d = now.getDate();
    if (m < 10) {
      m = "0" + m;
    }
    if (d < 10) {
      d = "0" + d;
    }
    return y + m + d;
  },
  getDeadlineWithoutHyphen: () => (str) => {
    let res = str.slice(0, 4) + str.slice(5, 7) + str.slice(8);
    return res;
  },
  getLabelByDeadline: (state, getters) => (start_date, end_date) => {
    let today = getters.getToday;
    if (today < parseInt(getters.getDeadlineWithoutHyphen(start_date))) {
      return { class: "badge-secondary", text: "公開前" };
    }
    if (parseInt(getters.getDeadlineWithoutHyphen(end_date)) < today) {
      return { class: "badge-danger", text: "公開終了" };
    }
    return { class: "badge-success", text: "公開中" };
  }
}
export default getters
