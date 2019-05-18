import Landing from "./components/Landing";
import Login from "./components/Login";
import AdminHome from "./components/Admin/Home";
import AdminUserCreate from "./components/Admin/User/Create";
import AdminRoleCreate from "./components/Admin/Role/Create";
import AdminRoleList from "./components/Admin/Role/List";
import AdminCollegeCreate from "./components/Admin/College/Create";
import AdminCollegeList from "./components/Admin/College/List";
import AdminCourseCreate from "./components/Admin/Course/Create";
import AdminCourseList from "./components/Admin/Course/List";
import AdminAySemesterView from "./components/Admin/AyAndSemester/View";
import AdminSubjectCreate from "./components/Admin/Subject/Create";

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
        },
        {
            path: '/admin/college/create',
            name: 'admin_college_create',
            component: AdminCollegeCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/college/list',
            name: 'admin_college_list',
            component: AdminCollegeList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/course/create',
            name: 'admin_course_create',
            component: AdminCourseCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/course/list',
            name: 'admin_course_list',
            component: AdminCourseList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/ay-semester/view',
            name: 'admin_ay_semester_view',
            component: AdminAySemesterView,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/subject/create',
            name: 'admin_subject_create',
            component: AdminSubjectCreate,
            meta: { middlewareAuth: true }
        },
    ]
}
