<template>
    <div>
        <div class="form-group row col-md-7 ">
            <!-- search -->
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Search" v-model="filter.search">
                <!-- create radio buttons for the filter type -->
                <div class="form-check">
                    <input :checked="filter.type==='student_number'" class="form-check-input" type="radio" name="filter"
                        id="filter-all" value="student_number" v-model="filter.type">
                    <label class="form-check-label" for="filter-all">
                        Student Number
                    </label>
                </div>
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
            <div class=" col-md-2">
                <h4>
                    <a class="text-danger" href="#" @click.prevent="showModal('add')">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                </h4>
            </div>

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
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th>
                                                <!-- clickable link to toggle Sort and span for arrow -->
                                                <a @click.prevent="sortBy('student_number')">
                                                    Student Number

                                                </a>
                                                <span v-if="sort.field=='student_number'" class="arrow"
                                                    :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                <!-- first_name -->
                                                <a @click.prevent="sortBy('first_name')">
                                                    First Name

                                                </a>
                                                <span v-if="sort.field=='first_name'" class="arrow" :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                <!-- Last Name -->
                                                <a @click.prevent="sortBy('last_name')">
                                                    Last Name
                                                </a>
                                                <span v-if="sort.field=='last_name'" class="arrow" :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                <!-- Status -->
                                                <a @click.prevent="sortBy('status')">
                                                    Status

                                                </a>
                                                <span v-if="sort.field=='status'" class="arrow" :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="student in sortedStudents" :key="student.id">
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
                                        </tbody>
                                    </table>
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
            
            filter: {
                search: '',
                type: 'student_number',
            },

            sort: {
                field: 'student_number',
                order: 'desc',
                class: 'down',
            },

            pagination: {
                current_page: 1,
                per_page: 10,
                total: 0,
            },
        }
    },
    mounted() {
        this.getStudents();
    },
    methods:{
        getStudents() {
            // send the authorization along the request
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
            });
        },
        sortBy(field) {
            this.sort.field = field;
            if (this.sort.order === 'asc') {
                this.sort.order = 'desc';
                this.sort.class = 'down';
            } else {
                this.sort.order = 'asc';
                this.sort.class = 'up';
            }
        },
        showModal(type, student) {
            this.student = {
                id: '',
                student_number: '',
                first_name: '',
                last_name: '',
                status: '',
            };
            if (type == 'edit') {
                this.student = student;
            }
            $('#modal-' + type).modal('show');
        },
    },

    computed:{
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
            const students = this.filteredStudents;
            const field = this.sort.field;
            const order = this.sort.order;
            // if string, use toLowerCase
            return students.sort((a,b) => {
                // if last_name, middle_name, first_name, do a string sorting
                if(typeof a[field] == 'string'){
                    return order == 'asc' ? a[field].toLowerCase() > b[field].toLowerCase() : a[field].toLowerCase() < b[field].toLowerCase();
                }
                else{
                    return order == 'asc' ? a[field] > b[field] : a[field] < b[field];
                }
            });
        },
    }

}
</script>

<style scoped>
    /* arrow class */
    .arrow {
        width: 0;
        height: 0;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid #000;
        margin: 4px 3px;
        cursor:pointer;
    }
    .up{
        transform: rotate(180deg);
    }
    .down{
        transform: rotate(0deg);
    }

</style>