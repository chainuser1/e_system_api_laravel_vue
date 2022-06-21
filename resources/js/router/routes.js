// import pages
import LoginPage from '../pages/auths/LoginPage';
import RegisterPage from '../pages/auths/RegisterPage';
import HomePage from '../pages/HomePage';
import AdminRoute from '../components/admin/widgets/AdminRoute';
import ManageStudents from '../components/admin/widgets/ManageStudents';
import ManagePersonnels from '../components/admin/widgets/ManagePersonnels';
import DashBoard from '../components/admin/widgets/DashBoard';
import ProfileView from '../components/user/widgets/ProfileView';
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
        path: '/admin-dashboard',
        component: ManageStudents,
        name: 'manage_students',
        meta: { requiresAuth: true }
    },
    {
        path: '/admin-personnel-management',
        component: ManagePersonnels,
        name: 'manage_personnels',
        meta: { requiresAuth: true }
    },
    {
        path: '/admin-profile/:id/:type',
        component: ProfileView,
        name: 'person_details',
        meta: { requiresAuth: true }
    },
    {
        path: '/admin-dashboard',
        component: DashBoard,
        name: 'admin_dashboard',
        meta: { requiresAuth: true }
    }
    

];

export default routes;
