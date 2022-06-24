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
                      <!-- subtitle -->
                        <h6 class="card-subtitle mb-2 text-muted">
                            <!-- {{subject.instructor.name}} -->
                        </h6>
                      <div >
                          <a href="#" @click.prevent="actionGoBack">
                              <i class="text-primary fas fa-arrow-left"></i>
                          </a>
                      </div>

                  </div>
                </div>
                <div class="card-body">
                  
                    <div :key="activity.id" class="card" v-for="activity of activities">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-book"></i>
                                {{activity.title}}
                            </h3>
                            
                        </div>

                        <div class="card-body">
                           
                            <p class="card-text alert alert-info">
                                {{activity.description}}
                            </p>
                            <div v-if="activity.file_url" class="card-text">
                                <a href="#" @click.prevent="actionDownloadActivity(activity)" class="btn btn-primary">
                                    <i class="fas fa-download"></i>
                                    Download
                                </a>
                            </div>
                            <!-- Reply -->
                            <div v-if="activity.reply" class="card-text">
                                <p class="card-text">
                                    <i class="fas fa-comment"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                                    
                </div>
            </div>
        </div>
   </div>

</template>

<script>
export default {
    name:'LearnSubjectPage',
    data(){
        return {
            loading:true,
            subject:{},
            activities: []
        }
    },
    methods:{
        actionGoBack(){
            this.$router.go(-1);
        },
        actionDownloadActivity(activity){
        //    use XmlHttpRequest to download the file
            let root_url = this.$store.getters.rootUrl;
            console.log(root_url);
            // use fetch
            fetch(activity.file_url+'/download',{
                method:'GET',
                headers:{
                    'Authorization':'Bearer '+this.$store.getters.token,
                    'X-CSRF-TOKEN':window.Laravel.csrfToken,
                    // accept file download li
                }
            })//create a blob
            .then(response => response.blob())
            .then(blob => {
                // create a link to download the file
                let a = document.createElement('a');
                a.href = window.URL.createObjectURL(blob);
                a.download = activity.title;
                a.click();
            })
            
        },
        loadSubject(){
            axios.get(`/subjects/${this.$route.params.id}`,{
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then(({data})=>{
                this.subject = data
                this.activities = data.activities
            }).catch(({response})=>{
                this.$toast.error(response.data.message, 'Error');
            }).finally(()=>{
                this.loading = false;
            });
        }
    },
    created(){
        this.loadSubject();
    }
}
</script>

<style>

</style>