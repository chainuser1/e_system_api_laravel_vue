<template>
    <div class="container">
        <!-- create a dashboard using bootstrap -->
        <!-- Welcome -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Welcome, {{user.name}}</h4>
                    </div>
                    <div class="card-body">
                        <admin-page v-if="user.role === 'admin'"></admin-page>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import AdminPage from '../components/admin/AdminPage.vue';
export default {
    name: 'HomePage',
    components: {
        'admin-page':AdminPage
    },
    data() {
        return {
           
        }
    },
    mounted(){
        console.log('HomePage mounted');
        console.log(this.$store.getters.user);
    },
    computed:{
        user(){
            return this.$store.getters.user;
        }
    },
    
}
</script>