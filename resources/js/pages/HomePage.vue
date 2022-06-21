<template>
    <div class="container">
        <!-- create a dashboard using bootstrap -->
        <!-- Welcome -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Welcome, <span style="text-transform:capitalize;">{{!user?'':user.name}}</span></h4>

                    </div>
                    <div class="card-body">
                        <!-- <admin-page v-if="user.role=='admin'"></admin-page> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name: 'HomePage',
    data() {
        return {

        }
    },
    mounted(){

    },
    computed:{
        user(){
            return this.$store.getters.user;
        }
    },

}
</script>
