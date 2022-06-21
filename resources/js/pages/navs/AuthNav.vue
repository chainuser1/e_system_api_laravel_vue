<template>

        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->

            <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">

                    <div class="media">
                    <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                    <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">Call me whenever you can...</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                    </div>

                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                  <i class="fas fa-th-large"></i>
                </a>
            </li> -->
            <li class="nav-item dropdown" v-if="!isAuthenticated">
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
            <li class="nav-item dropdown" v-else>
                <a style="text-transform:capitalize;" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
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
        </ul>

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
