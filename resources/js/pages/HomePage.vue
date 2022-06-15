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
                        <p class="card-text">
                            You Role is: {{user.role}}
                        </p>
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
    computed:{
        user(){
            return this.$store.getters.user;
        }
    },
    
}
</script>