<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="card" style="overflow: hidden;">
                            <div class="card-header">
                                <h4 class="card-title">Personnels</h4>
                            </div>
                            <div class="card-body container">
                                <!-- loading -->
                                <div v-if="loading">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary" role="type">
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
                                                            <option :selected="filter.type=='employee_number'"
                                                                value="employee_number">Employee Number</option>
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
                                                        class="btn btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modelId">
                                                        <i class="fa fa-plus text-danger" aria-hidden="true"></i>
                                                    </button>

                                                    <button style="margin-left:1px;" @click.prevent="getPersonnels"
                                                        type="button" class="btn btn-outline-success">
                                                        <i class="fa fa-rotate text-success"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <th>
                                                <!-- clickable link to toggle Sort and span for arrow -->
                                                <a @click.prevent="sortBy('employee_number')">
                                                    Employee Number

                                                </a>
                                                <span v-if="sort.type=='employee_number'" :class="sort.class">
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
                                                <a @click.prevent="sortBy('type')">
                                                    Personnel Type

                                                </a>
                                                <span v-if="sort.type=='type'" :class="sort.class">
                                                </span>
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="personnel of personnelsPerPage" :key="personnel.id">
                                                <td>
                                                    <a href="#" @click.prevent="view_details('personnel',personnel)">{{
                                                        personnel.employee_number
                                                        }}</a>
                                                </td>
                                                <td>
                                                    {{ personnel.first_name }}
                                                </td>
                                                <td>
                                                    {{ personnel.last_name }}
                                                </td>
                                                <td>
                                                    {{ personnel.type }}
                                                </td>
                                                <td>
                                                    <a type="button" :href="`#?${personnel.id}/edit`"
                                                        @click.prevent="actionShow('show','edit',personnel)"
                                                        class="btn btn-outline-secondary senary"><i
                                                            class="fas fa-edit color-text-senary"></i></a>
                                                    <!-- delete personnel -->&nbsp;
                                                    <button class="btn btn-outline-danger"
                                                        @click.prevent="deletePersonnel(personnel)"><i
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
                                    <!-- display the no of personnels below the table -->
                                    <div class="row" v-if="!this.loading==true">
                                        <div class="col-12">
                                            <p class="text-secondary">
                                                Showing {{personnelsPerPage.length}} of {{personnels.length}}
                                                personnels
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

        <PersonnelFormPage v-if="action=='show'" v-bind:personnel="addOrUpdatePersonnel"
            v-on:add-personnel="addPersonnel" v-on:update-personnel="editPersonnel" v-on:action-show="actionShow">
        </PersonnelFormPage>
    </div>


</template>

<script>
import PersonnelFormPage from './PersonnelFormPage.vue';
export default {
    name: 'ManagePersonnels',
    components: {
        PersonnelFormPage
    },
    data() {
        return {
            personnels: [],

            personnel: {
                id: '',
                employee_number: '',
                first_name: '',
                last_name: '',
                middle_name:'',
                type: '',
                suffix:'',
            },
            action:'hide',

            filter: {
                search: '',
                type: 'employee_number',
            },

            sort: {
                type: 'employee_number',
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
        this.getPersonnels();
    },
    methods:{
        view_details(type, student) {
            this.$store.commit('setPerson', student);
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

        getPersonnels() {
            // send the authorization along the request
            this.personnels = []
            this.loading = true;
            axios.get('/personnels',{
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            }).then(({data}) => {
                // console.log(data);
                this.personnels = data
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
        addPersonnel(personnel) {
            axios.post('/personnels',personnel, {
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
                    this.getPersonnels();
                })
                .catch(error => {
                    // this.error = true
                    this.$toast.error(error.response.data.message, 'Error');
                    // this.errors = error.response.data.errors
                })
            // hide modal
            this.actionShow('hide')

        },

        // edit personnel
        editPersonnel(personnel) {
            axios.patch('/personnels/'+personnel.id,{...personnel}, {
                headers:{
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },

               })
                .then(({ data }) => {
                    this.actionShow('hide')
                    this.getPersonnels();
                    this.filter.search = personnel.employee_number
                    this.$toast.success(data.message, 'Success');
                    this.filter.type = 'employee_number'
                })

                .catch(error => {
                    this.$toast.error(error.response.data.message, 'Error');
                })
            // hide modal


        },

        deletePersonnel(personnel) {
            const that = this
            this.$toast.question(`Are you sure you want to delete ${personnel.first_name} ${personnel.last_name}`,'Delete Personnel',

                    {
                    theme: "light",
                    icon: "icon-person",
                    position: "topCenter",
                    progressBarColor: "rgb(0, 255, 184)",
                    buttons: [
                        [
                            "<button>Ok</button>",
                            function (instance, toast) {
                                axios.delete('/personnels/' + personnel.id, {
                                headers: {
                                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                              })
                                .then(({ data }) => {
                                    instance.success('Personnel has been deleted','Success')
                                })
                                .catch(error => {
                                    instance.error(error.response.data.message,'Error')
                                })
                                instance.hide({ transitionOut: "fadeOut" }, toast, "button");
                                that.getPersonnels()
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

        actionShow(showOrHide = 'hide', action = 'none', personnel = null) {
            // this.getManufacturers()
            console.log(showOrHide)
            if (showOrHide === 'show') {
                this.action = showOrHide
                this.personnel = personnel
                if ((action == 'edit' || action == 'add') && personnel != null) {
                    this.action = 'show'
                    this.personnel = personnel
                }
            }
            this.action = showOrHide
        },
    },

    computed:{
        totalPagesFiltered() {
            let personnels = this.sortedPersonnels
            return Math.ceil(personnels.length / this.pages.per_page)
        },

        addOrUpdatePersonnel() {
            return this.personnel
        },

        personnelsPerPage() {
            let personnels = this.sortedPersonnels;
            let from = (this.pages.current_page - 1) * this.pages.per_page;
            let to = from + this.pages.per_page;
            return personnels.slice(from, to);
        },


        filteredPersonnels(){
            const personnels = this.personnels;
            const search = this.filter.search;
            const type = this.filter.type;
            if(search.length>0){
                // use includes or find
                return personnels.filter(personnel => {
                    return personnel[type].toLowerCase().includes(search.toLowerCase());
                });
            }
            return personnels;
        },
        sortedPersonnels(){
            let personnels = this.filteredPersonnels;
            // if string, use toLowerCase
            let type = this.sort.type;
            return personnels.sort((a,b) => {
                // if sort type === 'employee_number' and is string
               if(this.sort.type==='employee_number'){
                  return this.sort.order === 'asc'? a.employee_number.localeCompare(b.employee_number) : b.employee_number.localeCompare(a.employee_number);
               }
            // if sort type === 'type' and is string
                else if(this.sort.type==='type'){
                    return this.sort.order === 'asc'? a.type.localeCompare(b.type) : b.type.localeCompare(a.type);
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
