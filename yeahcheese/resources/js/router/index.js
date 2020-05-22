import Vue from 'vue';
import Router from 'vue-router';
import store from '../store';

import EventsIndex from '../pages/eventsIndex.vue';
import EventsShow from '../pages/eventShow.vue';
import EventStore from '../pages/eventStore.vue';
import EventEdit from '../pages/EventEdit.vue';
import Login from '../pages/login.vue';
import Register from '../pages/register.vue'
import Index from '../pages/index.vue';
import E401 from '../pages/401.vue';
import E403 from '../pages/403.vue';
import E404 from '../pages/404.vue';
import E500 from '../pages/500.vue';

Vue.use(Router);

const routes = [
  {
    path: '/',
    component: Index
  },
  {
    path: '/login',
    component: Login,
    meta: { requiresNotAuth: true }
  },
  {
    path: '/register',
    component: Register,
    meta: { requiresNotAuth: true }
  },
  {
    path: '/events',
    component: EventsIndex,
    meta: { requiresAuth: true }
  },
  {
    path: '/events/event-:id',
    name: "eventShow",
    component: EventsShow,
  },
    {
    path: '/events/:id/edit',
    name: 'eventEdit',
    component: EventEdit
  },
  {
    path: '/events/new',
    component: EventStore,
    meta: { requiresAuth: true }
  },
  {
    path: '/401',
    component: E401
  },
  {
    path: '/403',
    component: E403
  },
  {
    path: '/404',
    component: E404
  },
  {
    path: '/500',
    component: E500
  },
  {
    path: '*',
    component: E404
  },
];

const router = new Router({
  mode: 'history',
  routes
});

router.beforeEach((to, from, next) => {
  // meta: requiresNotAuth ログインしてたらダメ
  if (to.matched.some(record => record.meta.requiresNotAuth) && store.getters['users/isLogin']) {
    next({ path: '/' });
  }

  // meta: requiresAuth ログイン必要
  if (to.matched.some(record => record.meta.requiresAuth) && !store.getters['users/isLogin']) {
    next({ path: '/login' });
  }
  next();
});

export default router;
