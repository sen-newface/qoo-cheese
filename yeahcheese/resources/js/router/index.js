import Vue from 'vue';
import Router from 'vue-router';

import Index from '../pages/index.vue';

Vue.use(Router);

const routes = [
  {
    path: '/',
    component: Index
  }
];

const router = new Router({
  mode: 'history',
  routes
});

export default router;
