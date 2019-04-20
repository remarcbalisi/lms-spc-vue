import Vue from 'vue';
import VueRouter from 'vue-router';
import LandingNavBar from "./components/LandingNavBar";
import AdminSideBar from "./components/Admin/SideBar";
import routes from './routes';
import './bootstrap';
import Auth from './auth.js';
import Api from './api.js';
import VModal from 'vue-js-modal';

Vue.use(VueRouter);
Vue.use(VModal);
const router = new VueRouter(routes);

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.middlewareAuth)) {
        if (!auth.check()) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            });

            return;
        }
    }

    next();
});


Vue.component('landing-nav-bar', LandingNavBar);
Vue.component('admin-side-bar', AdminSideBar);

window.BASE_URL = 'http://dev.lmsspcvue.test/';
window.auth = new Auth();
window.Event = new Vue;
window.api = new Api();

const app = new Vue({
    el: '#app',
    router: router
});
