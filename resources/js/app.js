import Vue from 'vue';
import VueRouter from 'vue-router';
import LandingNavBar from "./components/LandingNavBar";
import AdminSideBar from "./components/Admin/SideBar";
import LecturerSideBar from "./components/Lecturer/SideBar";
import LearnerSideBar from "./components/Learner/SideBar";
import routes from './routes';
import './bootstrap';
import Auth from './auth.js';
import Api from './api.js';
import VModal from 'vue-js-modal';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

// FONT AWESOME
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUserSecret } from '@fortawesome/free-solid-svg-icons';
import { faFileImage } from '@fortawesome/free-solid-svg-icons';
import { faFile } from '@fortawesome/free-solid-svg-icons';
import { faPaperclip } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faUserSecret, faFileImage, faFile, faPaperclip);
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = true

Vue.use(VueRouter);
Vue.use(VModal, { dialog: true });
Vue.use(Loading);
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
Vue.component('lecturer-side-bar', LecturerSideBar);
Vue.component('learner-side-bar', LearnerSideBar);

window.BASE_URL = 'http://dev.lmsspcvue.test/';
window.auth = new Auth();
window.Event = new Vue;
window.api = new Api();

const app = new Vue({
    el: '#app',
    router: router
});
