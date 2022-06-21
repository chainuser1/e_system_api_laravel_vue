<template>
  <div class="row py-2">
    <div class="col">
      <!-- create a card -->
      <div class="card">
        <div class="card-header">
          <!-- title of the header is to  -->
          <h4>Manage Subjects</h4>
        </div>
        <div class="card-body">
          <div v-if="loading">
            <div class="text-center">
              <div class="spinner-border text-secondary" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
          </div>
          <div class="container-fluid" v-else>
            <div class="row">
              <div class="col-lg-6">
                <!-- create a table -->
                <form @click.prevent="()=>{return false}">
                  <div class="form-group row d-flex justify-content-round">
                    <label for="search">Search</label>
                    <input type="text" class="form-control col-md-4" id="search" v-model="filter.search"
                      placeholder="Search">
                    <!-- search type -->
                    <select class="col-md-3" v-model="filter.type">
                      <option selected>--Search By--</option>
                      <option :selected="filter.type=='name'" value="name">Name</option>
                      <option :selected="filter.type=='code'" value="code">Code</option>
                    </select>
                  </div>
                </form>
                <table class="table table-bordered table-striped">
                  <!-- create a search form -->
                  <thead>
                    <tr>
                      <th>
                        <a @click.prevent="sortBy('code')">
                          Subject Code
                        </a>
                        <span v-show="sort.sort_by=='code'" :class="sort.class">
                        </span>
                      </th>
                      <th>
                        <a @click.prevent="sortBy('name')">
                          Subject Code
                        </a>
                        <span v-show="sort.sort_by=='name'" :class="sort.class">
                        </span>
                      </th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="subject in sortedSubjects" :key="subject.id">
                      <td>{{ subject.code }}</td>
                      <td>{{ subject.name }}</td>
                      <td>
                        <!-- edit -->
                        <button class="btn btn-sm btn-primary" @click.prevent="editSubject(subject)">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteSubject(subject.id)">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <td colspan="6" style="text-align:center;">
                      <!-- pagination -->
                      <ul class="pagination justify-content-center ">
                        <li class="page-item" v-if="pages.current_page > 1">
                          <a class="page-link" @click="first">
                            <i class="fas fa-angle-double-left text-senary"></i>
                          </a>
                        </li>
                        <li class="page-item">
                          <a @click="prev" v-if="pages.current_page > 1" class="page-link " tabindex="-1"
                            aria-disabled="true">
                            <i class="fas fa-angle-left text-senary"></i>
                          </a>
                        </li>


                        <!-- <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li> -->

                        <li class="page-item">
                          <a @click="next" class="page-link " v-if="pages.current_page < totalPagesFiltered">
                            <i class="fas fa-angle-right text-primary"></i>
                          </a>
                        </li>

                        <li class="page-item" v-if="pages.current_page < totalPagesFiltered">
                          <a class="page-link" @click="last">
                            <i class="fas fa-angle-double-right text-senary"></i>
                          </a>
                        </li>
                      </ul>
                    </td>
                  </tbody>
                </table>
              </div>
              <div class="col-lg-6">
                <!-- create a bootstrap form to add and edit-->
                <h4>Create/Edit Subject</h4>
                <form @submit.prevent="submitSubject">
                  <div class="form-group">
                    <label for="code">Subject Code</label>
                    <input type="text" class="form-control" v-model="subject.code" id="code" placeholder="Subject Code">
                  </div>
                  <div class="form-group">
                    <label for="name">Subject</label>
                    <input type="text" class="form-control" v-model="subject.name" id="name" placeholder="Subject">
                  </div>
                  <!-- description -->
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" v-model="subject.description" id="description" rows="3"></textarea>
                  </div>
                  <!-- select from instructors assign to handle this subject -->
                  <div class="form-group">
                    <label for="instructor">Instructor</label>
                    <select class="form-control" v-model="subject.instructor_id">
                      <option selected>--Select--</option>
                      <option v-bind:selected="subject.instructor_id===instructor.id" v-for="instructor in instructors"
                        :key="instructor.id" :value="instructor.id">
                        {{ instructor.name }}
                      </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary" :disabled="loading" type="submit">
                      <span v-if="form_loading">
                        <i class="fa fa-spinner fa-spin"></i>
                      </span>
                      <span v-else>
                        Save
                      </span>
                    </button>
                    <!-- empty -->
                    <button class="btn btn-danger" @click.prevent="emptySubject">
                      Clear Form
                    </button>
                  </div>
                </form>
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
    name: 'ManageSubjects',
    data(){
      return {
        subjects: [],
        instructors: [],
        subject: {
          id:0,
          name: '',
          code: '',
          description: '',
          instructor_id: 0,
          created_at: '',
          updated_at: '',
        },
        pages:{
          total: this.totalPagesFiltered,
          c_page: 1,
          current_page: 1,
          per_page: 5,
        },
        filter:{
          search: '',
          type: 'name',
        },
        sort:{
          sort_by: 'name',
          sort_order: 'desc',
          class: 'arrow up'
        },
        form_loading: false,
        loading: false,
      }
    },
    created(){
      this.getSubjects();
      this.getInstructors();
    },
    computed:{
      totalPagesFiltered(){
        return Math.ceil(this.subjects.length / this.pages.per_page);
      },
      filteredSubjects(){
        let subjects = this.subjects;
        if(this.filter.search.length > 0){
          return subjects.filter(subject => {
            if(this.filter.type === 'name'){
              return subject.name.toLowerCase().includes(this.filter.search.toLowerCase());
            }else if(this.filter.type === 'code'){
              return subject.code.toLowerCase().includes(this.filter.search.toLowerCase());
            }
          });
        }
        return subjects;
      },
      sortedSubjects(){
        // if filter is empty, return all subjectsl
        let subjects = this.filteredSubjects;
        let sort_by = this.sort.sort_by;
        let sort_order = this.sort.sort_order;

        // if sort_by == name and sort_order == desc, sort by name desc
        // use localeCompare to sort by name
        if(sort_by === 'name' && sort_order === 'desc'){
          return subjects.sort((a,b) => {
            return a.name.localeCompare(b.name);
          });
        }else if(sort_by === 'name' && sort_order === 'asc'){
          return subjects.sort((a,b) => {
            return b.name.localeCompare(a.name);
          });
        }else if(sort_by === 'code' && sort_order === 'desc'){
          return subjects.sort((a,b) => {
            return a.code.localeCompare(b.code);
          });
        }else if(sort_by === 'code' && sort_order === 'asc'){
          return subjects.sort((a,b) => {
            return b.code.localeCompare(a.code);
          });
        }
      }
    },
    methods: {
      sortBy(field) {
        // toggle sort order on click and according to field type
        this.sort.sort_by = field;
        if (this.sort.sort_order == 'asc') {
          this.sort.sort_order = 'desc'
          this.sort.class = 'arrow down'
        }
        else {
          this.sort.sort_order = 'asc'
          this.sort.class = 'arrow up'
        }
      },
      next() {
        if (this.pages.current_page < this.totalPagesFiltered) {
          this.pages.current_page++;
        }

      },
      prev() {
        if (this.pages.current_page > 1) {
          this.pages.current_page--;
        }

      },

      last() {
        this.pages.current_page = this.totalPagesFiltered;
      },


      first() {
        this.pages.current_page = 1;
      },
      goToPage() {
        if (this.pages.c_page > 0 && this.pages.c_page <= this.totalPagesFiltered) {
          this.pages.current_page = this.pages.c_page;
        }
        else {
          alert('Page number is not valid')
        }
      },
      refresh(){
        this.getSubjects();
        this.getInstructors();
      },
      getSubjects(){
        this.loading = true;
        axios.get('/subjects', {
          headers:{
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
          },
        })
        .then(({data})=>{
          this.subjects = data
          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
          // use toaster
          this.$toast.error(error.response.data.message, 'Error');
        });
      },
      getInstructors(){
        this.loading = true;
        axios.get('/instructors', {
          headers:{
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
          },
        })
        .then(({data})=>{
          this.instructors = data
          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
          // use toaster
          this.$toast.error(error.response.data.message, 'Error');
        });
      },
      editSubject(subject){
        this.subject = subject;
      },
      deleteSubject(subject){
        this.loading = true;
        axios.delete('/subjects/'+subject.id, {
          headers:{
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
          },
        })
        .then(({data})=>{
          this.refresh();
          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
          // use toaster
          this.$toast.error(error.response.data.message, 'Error');
        });
      },
      submitSubject(){
        this.form_loading = true;
        
        axios.put('/subjects/'+this.subject.id, this.subject, {
          headers:{
            'Accept': 'application/json',
            'Authorization': 'Bearer ' +localStorage.getItem('token'),
          },
        })
        .then(({data})=>{
          this.refresh();
          this.$toast.success(data.message, 'Success');
           this.emptySubject();
        })
        .catch(error => {
          this.$toast.error(error.response.data.message, 'Error');
        }).finally(()=>{
          this.form_loading = false;
         
        });
      },  
      emptySubject(){
        this.subject = {
          id:0,
          name: '',
          code: '',
          description: '',
          instructor_id: 0,
          created_at: '',
          updated_at: '',
        };
      },


    }
}
</script>

<style scoped>
.arrow {
  border: 2px solid rgb(15, 5, 5);
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
}


.up {
  transform: rotate(-135deg);
  -webkit-transform: rotate(-135deg);
}

.down {
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
}
</style>