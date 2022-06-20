<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="card" style="overflow: hidden;">
                            <div class="card-header">
                                <h4 class="card-title">Students</h4>
                            </div>
                            <div class="card-body container">
                                <!-- loading -->
                                <div v-if="loading">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="" v-else>
                                    <div class="alert row bg-" style="overflow-x:hidden;">
                                        <!-- remove scrollbar upon overflow -->
                                        <div class="col">
                                            <form class="d-flex" @submit.prevent="">
                                                <div class="row">
                                                    <input class="col-md-6 form-control me-4" v-model="filter.search"
                                                        type="search" :placeholder="`Search by ${filter.type}` "
                                                        aria-label="Search">
                                                    <fieldset class="col-md-3 d-flex">

                                                        <select v-model="filter.type">
                                                            <option selected>--Filter Seearch--</option>
                                                            <option :selected="filter.type=='student_number'"
                                                                value="student_number">Student Number</option>
                                                            <option :selected="filter.type=='first_name'"
                                                                value="first_name">First Name</option>
                                                            <option :selected="filter.type=='last_name'"
                                                                value="last_name">Last Name</option>
                                                            <option :selected="filter.type=='middle_name'"
                                                                value="middle_number">Middle Name</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="d-flex justify-content-around col-md-4">
                                                    <button @click="actionShow('show','add')" type="button"
                                                        class="btn btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#modelId">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>

                                                    <a @click.prevent="getStudents" type="button"
                                                        class="btn btn-outline-secondary">
                                                        <i class="fa fa-rotate" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
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
                                                    <a href="#"
                                                         @click.prevent="view_details('student',student)" > {{ student.student_number
                                                    }}</a> 
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
                                                    <a type="button" :href="`#?${student.id}/edit`"
                                                        @click.prevent="actionShow('show','edit',student)"
                                                        class="btn btn-outline-success senary"><i
                                                            class="fas fa-edit color-text-senary"></i></a>
                                                    <!-- delete student -->&nbsp;
                                                    <button class="btn btn-outline-danger"
                                                        @click.prevent="deleteStudent(student)"><i
                                                            class="fa fa-eraser color-text-tertiary"
                                                            aria-hidden="true"></i></button>
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
                                                            <i class="fas fa-angle-right text-primary"></i>
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

        <StudentFormPage v-if="action=='show'" v-bind:student="addOrUpdateStudent" v-on:add-student="addStudent"
            v-on:update-student="editStudent" v-on:action-show="actionShow"></StudentFormPage>
    </div>


</template>

<script>
import StudentFormPage from './StudentFormPage.vue';
export default {
    name: 'ManageStudents',
    components: {
        StudentFormPage
    },
    data() {
        return {
            students: [],

            student: {
                id: '',
                student_number: '',
                first_name: '',
                last_name: '',
                middle_name:'',
                status: '',
                suffix:'',
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
            that:null
        }
    },
    mounted() {
        this.getStudents();
    },
    methods:{


        view_details(type,student){
            this.$store.commit('setPerson',student);
            this.$router.push({
                name: 'person_details',
                params: {
                    type: type,
                    id: student.id
                }
            })
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

        getStudents() {
            // send the authorization along the request
            this.students = []
            this.loading = true;
            axios.get('/students',{
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            }).then(({data}) => {
                // console.log(data);
                this.students = data
            }).catch(error => {
                this.$toast.error(error.response.data.message, 'Error');
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
            axios.post('/students',student, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
                .then(({ data }) => {
                    // this.success = true
                    this.$toast.success(data.message, 'Success');
                    this.sort.type = 'id';
                    this.sort.order = 'desc'
                    this.sort.class = 'arrow down'
                    this.getStudents();
                })
                .catch(error => {
                    // this.error = true
                    this.$toast.error(error.response.data.message, 'Error');
                    // this.errors = error.response.data.errors
                })
            // hide modal
            this.actionShow('hide')

        },

        // edit student
        editStudent(student) {
            axios.patch('/students/'+student.id,{...student}, {
                headers:{
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },

               })
                .then(({ data }) => {
                    this.actionShow('hide')
                    this.getStudents();
                    this.filter.search = student.student_number
                    this.$toast.success(data.message, 'Success');
                    this.filter.type = 'student_number'
                })

                .catch(error => {
                    this.$toast.error(error.response.data.message, 'Error');
                })
            // hide modal


        },

        deleteStudent(student) {
            const that = this
            this.$toast.question(`Are you sure you want to delete ${student.first_name} ${student.last_name}`,'Delete Student',

                    {
                    theme: "light",
                    icon: "icon-person",
                    position: "topCenter",
                    progressBarColor: "rgb(0, 255, 184)",
                    buttons: [
                        [
                            "<button>Ok</button>",
                            function (instance, toast) {
                                axios.delete('/students/' + student.id, {
                                headers: {
                                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                              })
                                .then(({ data }) => {
                                    instance.success('Student has been deleted','Success')
                                })
                                .catch(error => {
                                    instance.error(error.response.data.message,'Error')
                                })
                                instance.hide({ transitionOut: "fadeOut" }, toast, "button");
                                that.getStudents()
                            },
                            true
                        ],
                        [
                            "<button>Close</button>",
                            function (instance, toast) {
                                instance.hide(
                                    {
                                        transitionOut: "fadeOutUp",
                                        onClosing: function (instance, toast, closedBy) {
                                            console.info("closedBy: " + closedBy);
                                        }
                                    },
                                    toast,
                                    "buttonName"
                                );
                            }
                        ]
                    ],
                    onOpening: function (instance, toast) {
                        console.info("callback abriu!");
                    },
                    onClosing: function (instance, toast, closedBy) {
                        console.info("closedBy: " + closedBy);
                    }
                }

            )

        },

        actionShow(showOrHide = 'hide', action = 'none', student = null) {
            // this.getManufacturers()
            console.log(showOrHide)
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
