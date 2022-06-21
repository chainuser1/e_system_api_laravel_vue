<template>
    <div class="row py-2">
        <div class="col">
            <!-- create a bootstrap card -->
            <div class="card">
                <div class="card-header">
                    <!-- create a title and a search box for course -->
                    <h3 class="card-title">
                        <i class="fas fa-book"></i>
                        Courses
                    </h3>
                    <div class="card-tools col-md-6">
                        <div class="input-group input-group-lg ">
                            <form @submit.prevent="()=>{return false}">
                                <input v-model="filter.search" type="search" name="table_search"
                                    class="form-control float-right " placeholder="Search">
                                <!-- <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
                <!-- loading is true -->
                <div v-if="loading" class="card-body">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div v-else class="card-body d-flex justify-content-arou</div>nd">
                    <div  :key="subject.id" v-for="subject of filterSubjects" class="col-lg-3 col-6">
                        <subject-widget :subject="subject"></subject-widget>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SubjectWidget from './SubjectWidget';
export default {
    name: 'InstructorDashboard',
    components: {
        'subject-widget':SubjectWidget
    },
    data() {
        return {
            subjects: [],
            filter:{
                search: '',
            },
            loading: false,
        }
    },
    methods: {
        getSubjects() {
            this.loading = true;
            axios.get(`/instructors/${this.user.id}/subjects`,{
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                this.subjects = response.data.data;
                this.$toast.success(response.data.message, 'Success');
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, 'Error');
            }).finally(() => {
                this.loading = false;
            });
                
        },
    },
    computed:{
        user(){
            return this.$store.state.user;
        },
        filterSubjects(){
            // use localeCompare to search for name using filter.search
            let subjects = this.subjects
            // use includes to search for code using filter.search
            if(this.filter.search.length > 0){
                subjects = subjects.filter(subject => {
                    return subject.name.toLowerCase().includes(this.filter.search.toLowerCase()) || subject.code.toLowerCase().includes(this.filter.search.toLowerCase());
                });
            }
            return subjects;
        }
    },
    created() {
        this.getSubjects();
    }
}
</script>

<style>

</style>