<template>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a class="nav-link bg-danger" href="#" @click.prevent="actionGoTo('student_dashboard')">
                <span data-feather="home"></span>
                Dashboard <span v-show="link == 'student_dashboard'" class="sr-only">(current)</span>
            </a>
        </li>
       
    </ul>
</template>
<script>
export default {
    name: 'StudentRoutes',
    data() {
        return {
            link: 'student_dashboard'
        }
    },
    methods: {
        actionGoTo(link) {
            this.link = link
            this.$router.push({
                name: link
            })
        }
    },
    computed: {
        user() {
            return this.$store.getters.user;
        },
    },
    created() {
        this.actionGoTo(this.link)
    }
}
</script>
