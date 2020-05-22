export default {
  AUTH_ME: '/api/user/',
  AUTH_SIGNUP: '/api/signup',
  AUTH_LOGIN: '/api/login',
  EVENTS_INDEX: '/api/events',
  EVENTS_STORE: '/api/events',
  EVENTS_AUTH: '/api/events/auth',
  EVENTS_SHOW: (id, key) => '/api/events/' + id + '?key=' + key,
  EVENTS_UPDATE: (id) => '/api/events/' + id,
  EVENTS_DESTROY: (id) => '/api/events/' + id,
  PHOTOS_INDEX: (id) => '/api/events/' + id + 'photos',
  PHOTOS_STORE: (id) => '/api/events/' + id + 'photos',
  PHOTOS_DESTROY: (event_id, photo_id) => '/api/events/' + event_id + 'photos/' + photo_id
}