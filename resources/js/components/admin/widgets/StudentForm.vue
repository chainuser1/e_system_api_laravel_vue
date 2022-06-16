<template>
    <div class="modal-cs">
        <div class="modal-dialog modal-dialog-cs modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title">{{ this.student !== null ? 'Update Student' : 'Add Student' }}</h5>
                    <button type="button" @click="actionShow()">
                        <i class="fas fa-window-close    "></i>
                    </button>
                </div>
                <form @submit.prevent="student !== null ? updateStudent(new_student) : addStudent(new_student)">
                    <!-- <input type="hidden" :value ="updateStudent"/> -->
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" v-model="new_student.first_name" id="first_name"
                                    placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="name">Middle Name</label>
                                <input type="text" class="form-control" v-model="new_student.middle_name"
                                    id="middle_name" placeholder="Middle Name">
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control" v-model="new_student.last_name" id="last_name"
                                    placeholder=" Last Name">
                            </div>
                            <!-- selection  -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select v-model="new_student.status" class="form-control">
                                    <option disabled>--Select--</option>
                                    <option value="active" :selected="new_student.status=='active'">Active</option>
                                    <option value="inactive" :selected="new_student.status=='inactive'">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger color-secondary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</template>
<script>
export default {
    name: 'StudentForm',
    props: ['student'],
    components:{

    },
    data() {
        return {
            new_student: {
                id: this.student !== null ? this.student.id : '0',
                name: this.student !== null ? this.student.first_name : '',
                name: this.student !== null ? this.student.middle_name : '',
                name: this.student !== null ? this.student.last_name : '',
                // 
                student_number: !this.student?this.student.student_number:'',
                status: !this.student?this.studemt.status:'active'
            }
        }
    },
    methods: {
        updateStudent(student) {
            this.$emit('update-student', student);
        },
        addStudent(student) {
            this.$emit('add-student', student);
        },
        actionShow() {
            this.$emit('action-show');
        }
    }


}
</script>

<style scoped>
/* create a modal dialog */
.modal-cs {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
}

.modal-dialog-cs {
    width: 500px;
    height: auto;
    margin: auto;
}
</style>