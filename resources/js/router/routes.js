// import pages
import LoginPage from '../pages/auths/LoginPage';
import RegisterPage from '../pages/auths/RegisterPage';
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
    }

    // {
    //     path: '/',
    //     component: HomePage
    // },
];

export default routes;