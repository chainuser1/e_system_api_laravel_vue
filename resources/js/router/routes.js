// import pages
import LoginPage from '../pages/auths/LoginPage';
import RegisterPage from '../pages/auths/RegisterPage';
import HomePage from '../pages/HomePage';
import AdminPage from '../components/admin/AdminPage';
import ManageStudents from '../components/admin/widgets/ManageStudents';
// 
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
        path: '/admin',
        component: AdminPage,
        name:'admin',
        children:[
            {
                path: '/admin/manage-students',
                components:{
                    admin: ManageStudents
                },
                name:'manage-students',
            }
        ],
        meta: {requireAuth:true}
    },
    
];

export default routes;