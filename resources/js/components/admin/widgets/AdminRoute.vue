<template>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a class="nav-link bg-secondary" href="#" @click.prevent="actionGoTo('admin_dashboard')">
                <span data-feather="home"></span>
                Dashboard <span v-show="link=='admin_dashboard'" class="sr-only">(current)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-secondary" href="#" @click.prevent="actionGoTo('manage_students')">
                <span data-feather="home"></span>
                Manage Students<span v-show="link=='manage_students'" class="sr-only">(current)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-secondary" href="#" @click.prevent="actionGoTo('manage_personnels')">
                <span data-feather="home"></span>
                Manage Personnel<span v-show="link=='manage_personnels'" class="sr-only">(current)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-secondary" href="#" @click.prevent="actionGoTo('manage_subjects')">
                <span data-feather="home"></span>
                Manage Subjects<span v-show="link=='manage_subjects'" class="sr-only">(current)</span>
            </a>
        </li>
        <!-- <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="users"></span>
                        News
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="bar-chart-2"></span>
                        Gallery
                    </a>
                </li> -->



        <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Saved reports</span>
                <a class="d-flex align-items-center text-muted" href="#">
                    <span data-feather="plus-circle"></span>
                </a>
            </h6>
            <u class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="file-text"></span>
                        Current month
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="file-text"></span>
                        Last quarter
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="file-text"></span>
                        Memos
                    </a>
                </li>
             -->
    </ul>
</template>
<script>
export default {
    name: 'AdminRoute',
    data() {
        return {
            link: 'admin_dashboard'
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
    computed:{
        user(){
            return this.$store.getters.user;
        },
    },
    created(){
      this.actionGoTo(this.link)
    }
}
</script>
