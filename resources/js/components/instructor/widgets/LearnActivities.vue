<template>
    <div class="row">
        <!-- create something like canvas ilearn  -->
        <div class="col">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-bar-chart-o fa-fw"></i>
                        Learn Activities
                    </h3>
                </div>
                <div class="panel-body">
                    <div id="learn-activities-chart">
                        <!-- create a sort by select option -->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <form @submit.prevent="()=>false">
                                        <label for="sort-by">Sort by:</label>
                                        <select v-model="sort.sortBy" class="form-control" id="sort-by">
                                            <option value="">Select</option>
                                            <!-- option from activity keys or properties -->
                                            <option :selected="sort.sortBy=='title'" value="title">Title</option>
                                            <!-- <option :selected="sort.sortBy=='subject'" value="subject">Subject</option> -->
                                            <option :selected="sort.sortBy=='created_at'" value="created_at">Date
                                            </option>
                                        </select>
                                    </form>
                                </div>
                                <!-- add button to show modal -->
                                <div class="form-group d-flex">
                                    <button type="button" class="btn btn-secondary" @click="openModal('create')">

                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success" @click="getActivities">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                                <!-- refresh actiitis-->

                            </div>
                        </div>
                        <!-- loading animation -->
                        <div v-if="loading" class="col-md-5 offset-md-5">
                            <div class="loading-animation">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <table v-else class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <!-- <th>Subject</th> -->
                                    <th>Activity Title</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- loop through activity -->
                                <tr :key="index" v-for="(activity, index) of activities">
                                    <td>{{ index + 1 }}</td>
                                    <!-- <td>{{ activity.subject.name }}</td> -->
                                    <td>{{ activity.title }}</td>
                                    <td>{{ activity.created_at }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-xs"
                                            @click.prevent="openModal('edit',activity)">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-xs" @click="deleteActivity(activity)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- create a modal form -->
        <form @submit.prevent="createActivity" enctype="multipart/form-data">
            <div class="modal hide" id="create-activity-modal" tabindex="-1" role="dialog"
                aria-labelledby="create-activity-modal-label" aria-hidden="true">
                <!-- hidden input holds subject id   -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create-activity-modal-label">Create Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" v-model="activity.title" class="form-control" id="title"
                                    placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea v-model="activity.description" class="form-control" id="description"
                                    rows="3"></textarea>
                            </div>
                            <!-- if file upload -->
                            <!-- <div class="form-group">
                                <label for="file">File Upload</label>
                                <!-- input file and use change event -->
                                <!-- <input type="file" @change="onFileChange" class="form-control-file" id="file"
                                    accept=".zip">

                            </div> --> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                <!-- span for loading -->
                                <span v-if="loading">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                Create

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'LearnActivities',
    data() {
        return {
            activities: [],
            activity:{
                id:0,
                subject_id:this.$store.getters.subject,
                title: '',
                description: '',
                // file_url: null
                instructor_id:this.$store.getters.user.id
            },
            loading: true,
            sort:{
                sortBy: 'title',
                sortOrder: 'desc'
            },
            loading: false,

        }
    },
    methods:{
        deleteActivity(activity){
          this.loading=true;
          axios.delete('/activities/'+activity.id,{
              headers:{
                  'Authorization': 'Bearer ' + localStorage.getItem('token'),
                  'Accept': 'application/json'
              }
          }).then(({data})=>{
              this.$toast.success(data.message, 'Success');
          }).catch(error=>{
            this.$toast.error(error.response.data.message,'Error');
          }).finally(()=>{
            this.loading=false;
          })
        },
        resetActivity(){
            this.activity = {
                id:0,
                subject_id: this.$store.getters.subject.id,
                title: '',
                description: '',
                // file_url: null,
                instructor_id:this.$store.getters.user.id
            }
        },
        openModal(action,activity={}){
            $('#create-activity-modal').modal('show');
            if(action == 'edit'){
                this.activity = activity;
            }else{
                this.resetActivity();
            }
        },
        createActivity(){
            this.loading = true;
            // use axios to send data to server as well as upload file
            // create a new formData

            // send formData to server
            // console.log(formData.get('title'));
            axios.put('/activities/'+this.activity.id, {
              subject_id: this.$store.getters.subject.id,
              title: this.activity.title,
              description: this.activity.description,
              // file_url: null,
              instructor_id:this.$store.getters.user.id
            },{
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            })
            .then(response => {
                this.getActivities()
                this.resetActivity();
                this.$toast.success('Activity created successfully');
            })
            .catch(error => {
                this.$toast.error(error.response.data.message);
            }).finally(() => {
                $('#create-activity-modal').modal('hide');
                this.loading = false;
            });
        },

        onFileChange(){
            this.activity.file = this.$refs.file.files[0];
        },
        getActivities(){
            axios.get('/activities',{
                headers:{
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Accept': 'application/json'
                }
            }).
            then(({data}) => {
                this.activities = data;
                console.info(data)
                this.$toast.success('Activities loaded successfully');

            })
            .catch(error => {
                this.$toast.error(error.response.data.message,'Error');

            }).finally(() => {
              this.loading = false;
            })
        },
    },
    created(){
        this.getActivities();
    },
    computed:{

        sortedActivities(){
            let activities = this.activities
            return activities.sort((a,b) => {
            //  for string sort
                if(this.sort.sortBy == 'title'){
                    if(this.sort.sortOrder == 'asc'){
                        return a.title.localeCompare(b.title);
                    }else{
                        return b.title.localeCompare(a.title);
                    }

                }else if(this.sort.sortBy == 'created_at'){
                    // use number since this is a timsetamp
                    if(this.sort.sortOrder == 'asc'){
                        return a.created_at - b.created_at;
                    }else{
                        return b.created_at - a.created_at;
                    }
                }


            });

        }
    },
    watch:{
        sort:{
            // toggle sort order when sort by is changed
            handler(newVal,oldVal){
                if(newVal.sortBy != oldVal.sortBy){
                    this.sort.sortOrder = this.sort.sortOrder == 'asc' ? 'desc' : 'asc';
                }
            },
            deep:true
        },



    }
}
</script>

<style>

</style>
