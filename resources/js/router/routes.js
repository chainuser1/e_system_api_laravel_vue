// import pages
import LoginPage from '../pages/auths/LoginPage';
import RegisterPage from '../pages/auths/RegisterPage';
import HomePage from '../pages/HomePage';
import ManageStudents from '../components/admin/widgets/ManageStudents';
import ManagePersonnels from '../components/admin/widgets/ManagePersonnels';
import DashBoard from '../components/admin/widgets/DashBoard';
import ProfileView from '../components/user/widgets/ProfileView';
import ManageSubjects from '../components/admin/widgets/ManageSubjects';
// import components from instructor widgets
import InstructorDashboard from '../components/instructor/widgets/InstructorDashboard';
import LearnSubject from '../components/instructor/widgets/LearnSubject';
import store from '../store';
const routes = [
    {
        path: '/login',
        component: LoginPage,
        name: 'login',
        // redirect if authenticated
        beforeEnter: (to, from, next) => {
            if (store.getters.isAutneticated) {
                next('/');
            } else {
                next();
            }
        }
    },
    {
        path: '/register',
        component: RegisterPage,
        name: 'register',
        // redirect if authenticated
        beforeEnter: (to, from, next) => {
            if (store.getters.isAutneticated) {
                next('/');
            } else {
                next();
            }
        }
    },

    {
        path: '/',
        component: HomePage,
        name:'home',
        meta: { requiresAuth: true }
    },
    
    {
        path: '/admin/manage-students',
        component: ManageStudents,
        name: 'manage_students',
        meta: { requiresAuth: true }
    },
    {
        path: '/admin/personnel-management',
        component: ManagePersonnels,
        name: 'manage_personnels',
        meta: { requiresAuth: true }
    },
    {
        path: '/persona/profile/:id/:type',
        component: ProfileView,
        name: 'person_details',
        meta: { requiresAuth: true }
    },
    {
        path: '/admin/dashboard',
        component: DashBoard,
        name: 'admin_dashboard',
        meta: { requiresAuth: true }
    },
    {
        // for managing subjects
        path: '/admin/manage-subjects',
        component: ManageSubjects,
        name: 'manage_subjects',
        meta: { requiresAuth: true }
    },
    {
        path: '/instructor/instructors-dashboard',
        component: InstructorDashboard,
        name: 'instructor_dashboard',
        meta: { requiresAuth: true }
    },
    {
        path: '/instructor/instructor-subject-ilearn/:id',
        component: LearnSubject,
        name: 'instructor-subject-ilearn',
        meta: { requiresAuth: true }
    }
    

];

export default routes;
