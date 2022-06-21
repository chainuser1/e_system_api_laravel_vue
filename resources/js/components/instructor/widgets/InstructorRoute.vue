<template>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a class="nav-link bg-secondary" href="#" @click.prevent="actionGoTo('instructor_dashboard')">
                <span data-feather="home"></span>
                Dashboard <span v-show="link == 'instructor_dashboard'" class="sr-only">(current)</span>
            </a>
        </li>
       
    </ul>
</template>
<script>
export default {
    name: 'InstructorRoute',
    data() {
        return {
            link: 'instructor_dashboard'
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
