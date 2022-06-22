<template>
    <div class="small-box" :class="randomClass">
        <div class="inner">
            <p>
                <strong>{{ subject.name }}</strong>
            </p>
            <p>{{ subject.code }}</p>
        </div>
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a v-if="!isEnrolled" class="small-box-footer" @click.prevent="enrollSubject(subject)">Enroll 
            <!-- plus sign circle -->
            Enroll<i class="fas fa-plus"></i>
            <!-- span loading -->
            <div v-if="loading" class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </a>
        <!-- got to class -->
        <router-link v-else class="small-box-footer" :to="{name:'student_ilearn_subject', params:{id:subject.id}}">
            Go to class<i class="fas fa-arrow-circle-right"></i>
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'StudentSubjectWidget',
    props: ['subject','enrollments'],
    data(){
        return {
            loading: false,
        }
    },
    
    methods:{
        enrollSubject() {
            axios.post('/enrollments',{
                user_id: this.$store.getters.user.id,
                subject_id: this.subject.id,
            },{
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then(({data})=>{
                this.$toast.success(data.message, 'Success');
            }).catch(({response})=>{
                this.$toast.error(response.data.message, 'Error');
            }).finally(()=>{
                this.loading = false;
                this.reloadSubjects();
            });
        },

        reloadSubjects(){
            this.$emit('reload-subjects');
        }

    },
    computed:{
        user(){
            return this.$store.getters.user;
        },
        randomClass() {
            let classes = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
            return classes[Math.floor(Math.random() * classes.length)];
        },
        isEnrolled(){
            // return true if user is enrolled in this subject from enrollments
            return this.enrollments.find(enrollment => enrollment.subject.id == this.subject.id);
        }
    },
    
}
</script>

<style>

</style>