import Vue from 'vue';
import Router from 'vue-router';

import Login from '../pages/login.vue';

Vue.use(Router);

const routes = [
  {
    path: '/',
    component: Login
  }
];

const router = new Router({
  mode: 'history',
  routes
});

export default router;
