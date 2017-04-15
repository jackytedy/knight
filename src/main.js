import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routers';
import store from './store';
import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.css'
import FastClick from 'fastclick';
import { sync } from 'vuex-router-sync'
import mdIcon from './assets/md-icon.css'

import App from './App';
window.addEventListener('load', () => {
  FastClick.attach(document.body)
});
Vue.use(VueRouter);
const router = new VueRouter({
  routes,
});
router.beforeEach((to, from, next) => {
  console.log(to, from, next);
  next()
});
sync(store, router);
Vue.use(VueMaterial);
Vue.material.theme.registerAll({
  default: {
    primary: 'cyan',
    accent: 'pink'
  },
  indigo: {
    primary: 'indigo',
    accent: 'pink'
  }
});
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');





