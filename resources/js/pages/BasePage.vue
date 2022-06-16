<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" :href="root_url">
                    {{this.app_name}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <auth-nav v-on:logging-out="this.logout"></auth-nav>
            </div>
        </nav>

        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
import AuthNav from './navs/AuthNav.vue';

export default {
    name: 'BasePage',
    props:['app_name','root_url'],
    components: {
        'auth-nav':AuthNav
    },
    data() {
        return {

        }
    },
    computed:{
        user(){
            return this.$store.getters.user;
        },
        isAuthenticated(){
            return this.$store.getters.isAuthenticated;
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
            // route to  
            
        }
    }
    
}
</script>