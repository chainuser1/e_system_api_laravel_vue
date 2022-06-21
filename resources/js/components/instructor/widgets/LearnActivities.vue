<template>
    <div class="row">
        <!-- create something like canvas ilearn  -->
        <div class="col-md-12">
            <div class="panel panel-default">
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
                            <div class="col-md-7 d-flex">
                                <div class="form-group">
                                    <form @submit.prevent="()=>false">
                                        <label for="sort-by">Sort by:</label>
                                        <select v-model="sort.sortBy" class="form-control" id="sort-by">
                                            <option value="">Select</option>
                                            <!-- option from activity keys or properties -->
                                            <option :selected="sort.sortBy=='title'" value="title">Title</option>
                                            <option :selected="sort.sortBy=='subject'" value="subject">Subject</option>
                                            <option :selected="sort.sortBy=='created_at'" value="created_at">Date
                                            </option>
                                        </select>
                                    </form>
                                </div>
                                <!-- add button to show modal -->
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#create-activity-modal">
                                        <i class="fa fa-plus"></i>
                                        Create Activity
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- loading animation -->
                        <div v-if="loading" class="col-md-5">
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
                                    <th>Subject</th>
                                    <th>Activity Title</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- loop through activity -->
                                <tr :key="index" v-for="(activity, index) in activities">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ activity.subject }}</td>
                                    <td>{{ activity.title }}</td>
                                    <td>{{ activity.created_at }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-xs"
                                            @click.prevent="editActivity(activity)">
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
    </div>
</template>

<script>
export default {
    name: 'LearnActivities',
    data() {
        return {
            activities: [],
            loading: true,
            sort:{
                sortBy: 'title',
                sortOrder: 'desc'
            }
        }
    },
    methods:{
        
        getActivities(){
            this.$http.get('/activities',{
                headers:{
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Accept': 'application/json'
                }
            }).
            then(({data}) => {
                this.activities = data;
                this.$toast.success('Activities loaded successfully');
                this.loading = false;
            })
            .catch(error => {
                this.$toast.error(error.response.data.message,'Error');
            });
        },
    },
    created(){
        this.getActivities();
    },
    computed:{
        sortedActivities(){
            return this.activities.sort((a,b) => {
            //  for string sort
                if(this.sort.sortBy == 'title'){
                    if(this.sort.sortOrder == 'asc'){
                        return a.title.localeCompare(b.title);
                    }else{
                        return b.title.localeCompare(a.title);
                    }
                }else if(this.sort.sortBy == 'subject'){
                    if(this.sort.sortOrder == 'asc'){
                        return a.subject.localeCompare(b.subject);
                    }else{
                        return b.subject.localeCompare(a.subject);
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
        }
    }
}
</script>

<style>

</style>