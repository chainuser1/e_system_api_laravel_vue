<template>
    <div class="row">
        <!-- loading -->
        <div class="float-right" v-if="loading">
            <div v-if="loading" class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="col-md-12" v-else>
            <div class="card">
                <div class="card-header">
                  <div class="card-tools float-left">
                      <h4 class="card-title">
                          <i class="fas fa-book"></i>
                          {{subject.name}} - {{subject.code}}
                      </h4>
                      <div >
                          <a href="#" @click.prevent="actionGoBack">
                              <i class="text-danger fas fa-arrow-left"></i>
                          </a>
                      </div>

                  </div>


                </div>

                <!-- card-body for more info -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <!-- Description -->
                            <p>
                                <strong>Instructor:</strong>
                                {{subject.instructor.name}}
                            </p>
                        </div>
                        <div class="col">
                            <!-- Created At -->
                            <p>
                                <strong>Created At:</strong>
                                {{subject.created_at}}
                            </p>
                        </div>
                        <div class="col">
                            <p>
                              <strong>Created By:</strong>
                              {{subject.user.name}}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- another card about activities and students enrolled -->
                <div class="card">
                    <div class="card-header">
                          <ul class="nav">
                              <li class="nav-item">
                                <router-link :to="{name:'instructor-subject-students'}" class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <span>Students Enrolled to Subject</span>
                                </router-link>
                              </li>
                              <li class="nav-item">
                                <router-link :to="{name:'instructor-subject-activities'}" class="nav-link">
                                    <i class="fas fa-book"></i>
                                    <span>Activities</span>
                                </router-link>
                              </li>
                              <!-- <li class="nav-item">
                                <router-link :to="{name:'instructor-subject-submissions'}" class="nav-link">
                                    <i class="fas fa-book"></i>
                                    <span>Submissions</span>
                                </router-link>
                              </li> -->
                              <!-- <li class="nav-item">
                                <a class="nav-link disabled">Disabled</a>
                              </li> -->
                        </ul>

                    </div>
                    <!-- card body as router-view -->
                    <div class="card-body">
                        <router-view name="ilearn"></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LearnSubject',
    data(){
        return {
            subject: {},
            loading:false
        }
    },
    methods:{
        actionGoBack(){
            this.$router.go(-1)
        },
        // get subject from store
        getSubject(){
            this.loading = true
            // get subject id from params
            let subject_id = this.$route.params.id;
            // get subject from the server using axios
            axios.get('/subjects/'+subject_id,{
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(({data})=>{
                this.subject = data;
                this.$store.commit('setSubject',this.subject);
                this.$toast.success(this.subject.name+' loaded successfully');
            })
            .catch(error=>{
                this.$toast.error(error.response.data.message, 'Error');
            }).
            finally(()=>{
                this.loading = false
            })


        }
    },
    created(){
        this.getSubject()
    }
}
</script>

<style>

</style>
