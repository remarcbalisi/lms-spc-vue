import Landing from "./components/Landing";
import Login from "./components/Login";
import AdminHome from "./components/Admin/Home";
import AdminUserCreate from "./components/Admin/User/Create";
import AdminRoleCreate from "./components/Admin/Role/Create";
import AdminRoleList from "./components/Admin/Role/List";

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'landing',
            component: Landing
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/admin/home',
            name: 'admin_home',
            component: AdminHome,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/user/create',
            name: 'admin_user_create',
            component: AdminUserCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/role/create',
            name: 'admin_role_create',
            component: AdminRoleCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/role/list',
            name: 'admin_role_list',
            component: AdminRoleList,
            meta: { middlewareAuth: true }
        }
    ]
}
