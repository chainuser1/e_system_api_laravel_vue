<template>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
            <!-- home page vue-router-link-->
            <li class="nav-item">
                <router-link to="/" class="nav-link">Home</router-link>
            </li>

        </ul>


        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->

            <li class="nav-item dropdown" v-if="isAuthenticated">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    {{ user.role }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <!-- router-link profile -->
                    <a href="#" class="dropdown-item">{{ user.name }}</a>
                    <!-- router-link for logout -->
                    <a href="#" class="dropdown-item" @click.prevent="logout">Logout</a>

                </div>
            </li>


            <li class="nav-item dropdown" v-else>
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Account
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <!-- vue-router-links -->
                    <router-link class="dropdown-item" :to="{ name: 'login' }">Login</router-link>
                    <router-link class="dropdown-item" :to="{ name: 'register' }">Register</router-link>
                </div>
            </li>
        </ul>
    </div>

</template>
<script>
import Axios from 'axios';

export default {
    name:'AuthNav',
   data(){
       return{
    }
   },
    methods:{
                         
        logout() {
           this.$emit('logging-out');
           this.$router.push('/login')
        }
    },

    // create watchers to see for store.getters.isAuthenticated and store.getters.user
    computed:{
        user(){
            return this.$store.getters.user;
        },
        isAuthenticated(){
            return this.$store.getters.isAuthenticated;
        }
    }
}
</script>

