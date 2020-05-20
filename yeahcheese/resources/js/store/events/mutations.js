import * as types from '../mutation-types';

export default {
  setEventValidationMessage(state, mes) {
    state.validationMessage = mes
  },
  setEvent(state, event) {
    state.events.push(event)
  },
  updateEvent(state, event) {
    const targetIdx = state.events.findIndex((e) => e.id == event.id);
    state.events.splice(targetIdx, 1, event);
  },
  setNowEvent(state, event) {
    state.event = event;
  }
}
