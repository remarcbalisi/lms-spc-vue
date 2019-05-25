import Landing from "./components/Landing";
import Login from "./components/Login";

// Admin
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
import AdminSubjectList from "./components/Admin/Subject/List";
import AdminSectionCreate from "./components/Admin/Section/Create";
import AdminSectionList from "./components/Admin/Section/List";
import AdminClassroomCreate from "./components/Admin/Classroom/Create";
import AdminClassroomList from "./components/Admin/Classroom/List";
import AdminClassroomView from "./components/Admin/Classroom/View";

// Lecturer
import LecturerHome from "./components/Lecturer/Home";
    //course
import LecturerCourseCreate from "./components/Lecturer/Course/Create";
import LecturerCourseList from "./components/Lecturer/Course/List";
    //subject
import LecturerSubjectCreate from "./components/Lecturer/Subject/Create";
import LecturerSubjectList from "./components/Lecturer/Subject/List";
    //section
import LecturerSectionCreate from "./components/Lecturer/Section/Create";
import LecturerSectionList from "./components/Lecturer/Section/List";
    //classroom
import LecturerClassroomCreate from "./components/Lecturer/Classroom/Create";
import LecturerClassroomList from "./components/Lecturer/Classroom/List";
import LecturerClassroomView from "./components/Lecturer/Classroom/View";

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

        // Admin
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
        {
            path: '/admin/subject/list',
            name: 'admin_subject_list',
            component: AdminSubjectList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/section/create',
            name: 'admin_section_create',
            component: AdminSectionCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/section/list',
            name: 'admin_section_list',
            component: AdminSectionList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/classroom/create',
            name: 'admin_classroom_create',
            component: AdminClassroomCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/classroom/list',
            name: 'admin_classroom_list',
            component: AdminClassroomList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/admin/classroom/view/:id',
            name: 'admin_classroom_view',
            component: AdminClassroomView,
            meta: { middlewareAuth: true }
        },

        // Lecturer
        {
            path: '/lecturer/home',
            name: 'lecturer_home',
            component: LecturerHome,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/course/create',
            name: 'lecturer_course_create',
            component: LecturerCourseCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/course/list',
            name: 'lecturer_course_list',
            component: LecturerCourseList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/subject/create',
            name: 'lecturer_subject_create',
            component: LecturerSubjectCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/subject/list',
            name: 'lecturer_subject_list',
            component: LecturerSubjectList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/section/create',
            name: 'lecturer_section_create',
            component: LecturerSectionCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/section/list',
            name: 'lecturer_section_list',
            component: LecturerSectionList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/classroom/create',
            name: 'lecturer_classroom_create',
            component: LecturerClassroomCreate,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/classroom/list',
            name: 'lecturer_classroom_list',
            component: LecturerClassroomList,
            meta: { middlewareAuth: true }
        },
        {
            path: '/lecturer/classroom/view/:id',
            name: 'lecturer_classroom_view',
            component: LecturerClassroomView,
            meta: { middlewareAuth: true }
        },
    ]
}
