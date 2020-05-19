import * as types from '../mutation-types';

export default {
  setEventValidationMessage(state, mes) {
    state.validationMessage = mes
  },

  setEvent(state, event) {
    state.events.push(event)
  },

  delEvents(state) {
    state.events = []
  }
}
