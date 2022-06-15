<template>
    <div class="container">
        <!-- divide the panel into two with left and main-->
        <div class="row">
            <admin-route></admin-route>
            <main role="main" class="col-md-10">
                <router-view name="admin"></router-view>
            </main>
        </div>
    </div>
</template>

<script>

import AdminRoute from './widgets/AdminRoute.vue'
export default {
    name: 'AdminPage',
    components: {
        'admin-route':AdminRoute
    },
}
</script>

<style scoped>

</style>