<template>
    <div>
        <div class="form-group row col-md-7 ">
            <!-- search -->
            <div class="col-md-8">
                <form class="d-flex" @submit.prevent="">
                    <input class="form-control me-3" v-model="filter.search" type="search" placeholder="Search"
                        aria-label="Search">

                    <button @click="actionShow('show','add')" type="button" class="btn btn-outline-danger"
                        data-bs-toggle="modal" data-bs-target="#modelId">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>

                    <button style="margin-left:1px;" @click.prevent="getStudents" type="button"
                        class="btn btn-outline-success">
                        <i class="fa fa-rotate"></i>
                    </button>
                </form>
                <!-- last_name -->
                <div class="form-check">
                    <input :checked="filter.type==='last_name'" class="form-check-input" type="radio" name="filter"
                        id="filter-last_name" value="last_name" v-model="filter.type">
                    <label class="form-check-label" for="filter-last_name">
                        Last Name
                    </label>
                </div>
                <!--  first_name -->
                <div class="form-check">
                    <input :checked="filter.type==='first_name'" class="form-check-input" type="radio" name="filter"
                        id="filter-first_name" value="first_name" v-model="filter.type">
                    <label class="form-check-label" for="filter-first_name">
                        First Name
                    </label>
                </div>
                <!--  middle_name -->
                <div class="form-check">
                    <input :checked="filter.type==='middle_name'" class="form-check-input" type="radio" name="filter"
                        id="filter-middle_name" value="middle_name" v-model="filter.type">
                    <label class="form-check-label" for="filter-middle_name">
                        Middle Name
                    </label>

                </div>

            </div>
            <!-- add a button to add and pop-up the modal -->
            <!-- <div class=" col-md-2">
                <h4>
                    <a class="text-danger" href="#" @click.prevent="showModal('add')">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                </h4>
            </div> -->

            <!-- end search -->
            <!-- list students -->
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Students</h4>
                            </div>
                            <div class="card-body">
                                <!-- loading -->
                                <div v-if="loading">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive" v-else>

                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th>
                                                <!-- clickable link to toggle Sort and span for arrow -->
                                                <a @click.prevent="sortBy('student_number')">
                                                    Student Number

                                                </a>
                                                <span v-if="sort.type=='student_number'" :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                <!-- first_name -->
                                                <a @click.prevent="sortBy('first_name')">
                                                    First Name

                                                </a>
                                                <span v-if="sort.type=='first_name'" :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                <!-- Last Name -->
                                                <a @click.prevent="sortBy('last_name')">
                                                    Last Name
                                                </a>
                                                <span v-if="sort.type=='last_name'" :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                <!-- Status -->
                                                <a @click.prevent="sortBy('status')">
                                                    Status

                                                </a>
                                                <span v-if="sort.type=='status'" :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="student of studentsPerPage" :key="student.id">
                                                <td>
                                                    {{ student.student_number }}
                                                </td>
                                                <td>
                                                    {{ student.first_name }}
                                                </td>
                                                <td>
                                                    {{ student.last_name }}
                                                </td>
                                                <td>
                                                    {{ student.status }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary"
                                                        @click="editStudent(student)">Edit</button>
                                                    <button class="btn btn-danger"
                                                        @click="deleteStudent(student)">Delete</button>
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
                                                        <a @click="prev" v-if="pages.current_page > 1"
                                                            class="page-link " tabindex="-1" aria-disabled="true">
                                                            <i class="fas fa-angle-left text-senary"></i>
                                                        </a>
                                                    </li>


                                                    <!-- <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li> -->

                                                    <li class="page-item">
                                                        <a @click="next" class="page-link "
                                                            v-if="pages.current_page < totalPagesFiltered">
                                                            <i class="fas fa-angle-right text-senary"></i>
                                                        </a>
                                                    </li>

                                                    <li class="page-item"
                                                        v-if="pages.current_page < totalPagesFiltered">
                                                        <a class="page-link" @click="last">
                                                            <i class="fas fa-angle-double-right text-senary"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tbody>
                                    </table>
                                    <!-- display the no of students below the table -->
                                    <div class="row" v-if="!this.loading==true">
                                        <div class="col-12">
                                            <p class="text-secondary">
                                                Showing {{studentsPerPage.length}} of {{students.length}}
                                                students
                                                on page {{this.pages.current_page}} of {{this.totalPagesFiltered}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
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
    name: 'ManageStudents',
    data() {
        return {
            students: [],
            student: {
                id: '',
                student_number: '',
                first_name: '',
                last_name: '',
                status: '',
            },
            action:'hide',
            
            filter: {
                search: '',
                type: 'student_number',
            },

            sort: {
                type: 'student_number',
                order: 'desc',
                class: 'arrow up'
            },

            pages: {
                total: this.totalPagesFiltered,
                c_page: 1,
                current_page: 1,
                per_page: 5,
            },
            loading: false,
        }
    },
    mounted() {
        this.getStudents();
    },
    methods:{
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

        getStudents() {
            // send the authorization along the request
            this.loading = true;
            axios.get('/students',{
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            }).then(({data}) => {
                console.log(data);
                this.students = data.data
                this.pagination.total = data.data.total;
            }).catch(error => {
                console.log(error);
            })
            .finally(() => {
                this.loading = false;
            });
        },
        sortBy(field) {
            // toggle sort order on click and according to field type
            this.sort.type = field;
            if (this.sort.order == 'asc') {
                this.sort.order = 'desc'
                this.sort.class = 'arrow down'
            }
            else {
                this.sort.order = 'asc'
                this.sort.class = 'arrow up'
            }
        },
        addStudent(student) {
            console.log(student)
            axios.post(`http://localhost:5000/students/add`, student)
                .then(({ data }) => {
                    // this.success = true
                    this.$emit('show-message', {
                        success: true,
                        type: 'success',
                        title: 'Success',
                        message: data.message
                    })
                    this.sort.type = 'id';
                    this.sort.order = 'desc'
                })
                .catch(error => {
                    // this.error = true
                    alert(error.response.data.message);
                    // this.errors = error.response.data.errors
                })
            // hide modal
            this.actionShow('hide')

        },

        // edit student
        editStudent(student) {

            axios.put(`http://localhost:5000/students/${student.id}/edit`, student)
                .then(({ data }) => {
                    // this.success = true
                    this.$emit('show-message', {
                        success: true,
                        type: 'success',
                        title: 'Success',
                        message: data.message
                    })
                    this.filter.search = student.name
                })

                .catch(error => {
                    this.errorMessage = error.response.data.message
                    // this.errors = error.response.data.errors
                })
            // hide modal
            this.actionShow('hide')

        },

        deleteStudent(student) {

            axios.delete(`http://localhost:5000/students/${student.id}/delete`)
                .then(({ data }) => {
                    // this.success = true
                    this.$emit('show-message', {
                        success: true,
                        type: 'success',
                        title: 'Success',
                        message: data.message
                    })
                    this.filter.search = student.name
                })
                .catch(error => {
                    this.errorMessage = error.response.data.message
                })

        },

        actionShow(showOrHide = 'hide', action = 'none', student = null) {
            // this.getManufacturers()
            if (showOrHide === 'show') {
                this.action = showOrHide
                this.student = student
                if ((action == 'edit' || action == 'add') && student != null) {
                    this.action = 'show'
                    this.student = student
                }
            }
            this.action = showOrHide
        },
    },

    computed:{
        totalPagesFiltered() {
            let students = this.sortedStudents
            return Math.ceil(students.length / this.pages.per_page)
        },

        addOrUpdateStudent() {
            return this.student
        },

        studentsPerPage() {
            let students = this.sortedStudents;
            let from = (this.pages.current_page - 1) * this.pages.per_page;
            let to = from + this.pages.per_page;
            return students.slice(from, to);
        },


        filteredStudents(){
            const students = this.students;
            const search = this.filter.search;
            const type = this.filter.type;
            if(search.length>0){
                // use includes or find
                return students.filter(student => {
                    return student[type].toLowerCase().includes(search.toLowerCase());
                });
            }
            return students;
        },
        sortedStudents(){
            let students = this.filteredStudents;
            // if string, use toLowerCase
            let type = this.sort.type;
            return students.sort((a,b) => {
                // if sort type === 'student_number' and is string
               if(this.sort.type==='student_number'){
                  return this.sort.order === 'asc'? a.student_number.localeCompare(b.student_number) : b.student_number.localeCompare(a.student_number);
               }
            // if sort type === 'status' and is string
                else if(this.sort.type==='status'){
                    return this.sort.order === 'asc'? a.status.localeCompare(b.status) : b.status.localeCompare(a.status);
                }
                // if sort type === 'id' and is number
                else if(this.sort.type==='id'){
                    return this.sort.order === 'asc'? a.id > b.id : a.id < b.id;
                }
                // if sort type === 'first_name' and is string
                else if(this.sort.type==='first_name'){
                    return this.sort.order === 'asc'? a.first_name.localeCompare(b.first_name) : b.first_name.localeCompare(a.first_name);
                }
                // }
                // if sort type === 'last_name' and is string
                else if(this.sort.type==='last_name'){
                    return this.sort.order === 'asc'? a.last_name.localeCompare(b.last_name) : b.last_name.localeCompare(a.last_name);
                }
               
            });
        },
    },

    watch:{
        'filter.search': function () {
            this.pages.current_page = 1
        },
        'pages.current_page': function () {
            this.pages.c_page = this.pages.current_page
        },
    }

}
</script>

<style scoped>
    /* arrow class */
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