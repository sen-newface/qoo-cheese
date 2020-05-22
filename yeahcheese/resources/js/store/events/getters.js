import store from '../../store'
const getters = {
  events: state => state.events.slice().sort(function (a, b) {
    return (a.id > b.id ? 1 : -1)
  }),
  initLoad: state => state.initLoad,
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
