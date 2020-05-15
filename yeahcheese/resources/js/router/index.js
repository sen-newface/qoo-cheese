import Vue from 'vue';
import Router from 'vue-router';

import store from '../store';
import Index from '../pages/index.vue';
import Register from '../pages/register.vue'

Vue.use(Router);

const routes = [
  {
    path: '/',
    component: Index
  },
  {
    path: '/register',
    component: Register,
    meta: { requiresNotAuth: true }
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
