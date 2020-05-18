import Vue from 'vue';
import Router from 'vue-router';
import store from '../store';

import Login from '../pages/login.vue';
import Register from '../pages/register.vue'
import Index from '../pages/index.vue';
import E401 from '../pages/401.vue';
import E403 from '../pages/403.vue';
import E404 from '../pages/404.vue';
import E500 from '../pages/500.vue';
import EventStore from '../pages/eventStore.vue'

Vue.use(Router);

const routes = [
  {
    path: '/',
    component: Index
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
    path: '/login',
    component: Login
  },
  {
    path: '/register',
    component: Register,
    meta: { requiresNotAuth: true }
  },
  {
    path: '/events/new',
    component: EventStore
  }
];

const router = new Router({
  mode: 'history',
  routes
});

router.beforeEach((to, from, next) => {
  // if (to.matched.some(record => record.meta.requiresNotAuth) && store.getters['users/isLogin']) {
  //   next({ path: '/' });
  // }
  next();
});

export default router;
