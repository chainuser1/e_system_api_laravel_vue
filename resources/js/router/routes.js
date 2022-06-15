// import pages
import LoginPage from '../pages/auths/LoginPage';
import RegisterPage from '../pages/auths/RegisterPage';
import HomePage from '../pages/HomePage';
const routes = [
    {
        path: '/login', 
        component: LoginPage,
        name: 'login'
    },
    {
        path: '/register',
        component: RegisterPage,
        name: 'register'
    },

    {
        path: '/',
        component: HomePage,
        name:'home',
        meta: { requiresAuth: true }
    },
];

export default routes;