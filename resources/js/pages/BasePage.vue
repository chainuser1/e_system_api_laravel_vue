<template>
    <div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <a class="navbar-brand" :href="root_url">E-Systems
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item d-none d-sm-inline-block">
                        <router-link class="nav-link active ms-0" to="/">Home</router-link>
                    </li>
                </ul>
                <auth-nav v-on:logging-out="this.logout"></auth-nav>
            </div>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4" >
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <!-- <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div> -->
                    <div class="info">
                        <a href="#" class="d-block">{{!user?'Guest':user.name}}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <!-- <router-view name="routes_main"></router-view> -->
                    <admin-route v-if="isAdmin"></admin-route>
                </nav>
            </div>


        </aside>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="#">E-Systems</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>

</template>
<script>
import AuthNav from './navs/AuthNav.vue';
import AdminRoute from '../components/admin/widgets/AdminRoute.vue';
export default {
    name: 'BasePage',
    props:['app_name','root_url'],
    components: {
        'auth-nav':AuthNav,
        'admin-route':AdminRoute
    },
    data() {
        return {

        }
    },
    computed:{
        user(){
            // return user from store or null
            return this.$store.getters.user?this.$store.getters.user:null;
        },
        isAuthenticated(){
            return this.$store.getters.isAuthenticated;
        },
        isAdmin(){
            return this.$store.getters.user ? this.$store.getters.user.role =='admin':false;
        }
    },
    methods:{
        logout(){
            axios.delete('/logout',{
                headers:{
                    'X-CSRF-TOKEN':window.Laravel.csrfToken,
                    'Authorization':'Bearer '+localStorage.getItem('token'),
                    'Accept':'application/json'
                }
            }).finally(() => {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                this.$store.commit('setUser', null);
                this.$store.commit('setIsAuthenticated', false);
                this.$toast.success(data.message, 'Success');

            });

        }

    },
    created(){
        // if user is admin route to dashboard
        if(this.isAdmin){
            this.$router.push({name:'admin_dashboard'});
        }
    }

}
</script>
<style scoped>

</style>
