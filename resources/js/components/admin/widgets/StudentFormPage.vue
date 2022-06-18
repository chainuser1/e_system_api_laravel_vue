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

                <div class="modal-body">
                    <form @submit.prevent="student !== null ? updateStudent(new_student) : addStudent(new_student)">
                        <div class="container">
                            <div class="form-group row">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" v-model="new_student.first_name" id="first_name"
                                    placeholder="First Name">
                            </div>
                            <div class="form-group row">
                                <label for="name">Middle Name</label>
                                <input type="text" class="form-control" v-model="new_student.middle_name"
                                    id="middle_name" placeholder="Middle Name">
                            </div>
                            <div class="form-group row">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control" v-model="new_student.last_name" id="last_name"
                                    placeholder=" Last Name">
                            </div>

                            <div class="form-group row">
                                <label for="status">Status</label>
                                <select v-model="new_student.status" class="form-control">
                                    <option disabled>--Select--</option>
                                    <option value="active" :selected="new_student.status=='active'">Active</option>
                                    <option value="inactive" :selected="new_student.status=='inactive'">Inactive
                                    </option>
                                </select>
                            </div>

                            <!-- suffic -->
                            <div class="form-group row">
                                <label for="suffix">Suffix</label>
                                <select v-model="new_student.suffix" class="form-control">
                                    <option selected value="">--Select--</option>
                                    <option value="Jr." :selected="new_student.suffix=='Jr.'">Jr.</option>
                                    <option value="Sr." :selected="new_student.suffix=='Sr.'">Sr.</option>
                                    <option value="II" :selected="new_student.suffix=='II'">II</option>
                                    <!-- other (allow input if not found above) -->
                                    <option value="Please Specify" :selected="new_student.suffix!=='Jr.' &&
                                    new_student.suffix  !== 'Sr.' && new_student.suffix !== 'II'" >Other
                                    </option>
                                </select>
                                <input v-if="listenForOther"  type="text" v-model="new_student.suffix" class="form-control"
                                    placeholder="Please Specify">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger color-secondary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</template>
<script>
export default {
    name: 'StudentFormPage',
    props: ['student'],
    data() {
        return {
            new_student: {
                suffix: !this.student? '': this.student.suffix,
                first_name: !this.student ? '' : this.student.first_name,
                middle_name: !this.student ? '' : this.student.middle_name,
                last_name: !this.student ? '' : this.student.last_name,
                status: !this.student ? 'active' : this.student.status,
                student_number: !this.student ? '' : this.student.student_number,
                id: !this.student ? 0 : this.student.id,
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
        },

    },

    computed:{
        listenForOther(){
            if(this.new_student.suffix!=='Jr.' &&
            this.new_student.suffix  !== 'Sr.' && this.new_student.suffix !== 'II' && this.new_student.suffix !== ''){
                return true;
            }
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

.modal-dialog-cs .modal-body{
    width: 500px;
    height: auto;
    margin: auto;
    height: fit-content;
}
</style>
