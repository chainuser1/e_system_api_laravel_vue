<template>
    <div class="modal-cs">
        <div class="modal-dialog modal-dialog-cs modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title">{{ this.personnel !== null ? 'Update Personnel' : 'Add Personnel' }}</h5>
                    <button type="button" @click="actionShow()">
                        <i class="fas fa-window-close    "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form @submit.prevent="personnel !== null ? updatePersonnel(new_personnel) : addPersonnel(new_personnel)">
                        <div class="container">
                            <div class="form-group row">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" v-model="new_personnel.first_name" id="first_name"
                                    placeholder="First Name">
                            </div>
                            <div class="form-group row">
                                <label for="name">Middle Name</label>
                                <input type="text" class="form-control" v-model="new_personnel.middle_name"
                                    id="middle_name" placeholder="Middle Name">
                            </div>
                            <div class="form-group row">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control" v-model="new_personnel.last_name" id="last_name"
                                    placeholder=" Last Name">
                            </div>

                            <div class="form-group row">
                                <label for="type">Type</label>
                                <select v-model="new_personnel.type" class="form-control">
                                    <option disabled>--Select--</option>
                                    <option value="admin" :selected="new_personnel.type=='admin'">admin</option>
                                    <option value="instructor" :selected="new_personnel.type=='instructor'">Instructor
                                    </option>
                                    <option value="staff" :selected="new_personnel.type=='staff'">staff</option>
                                </select>
                            </div>

                            <!-- suffic -->
                            <div class="form-group row">
                                <label for="suffix">Suffix</label>
                                <select v-model="new_personnel.suffix" class="form-control">
                                    <option selected value="">--Select--</option>
                                    <option value="Jr." :selected="new_personnel.suffix=='Jr.'">Jr.</option>
                                    <option value="Sr." :selected="new_personnel.suffix=='Sr.'">Sr.</option>
                                    <option value="II" :selected="new_personnel.suffix=='II'">II</option>
                                    <!-- other (allow input if not found above) -->
                                    <option value="Please Specify" :selected="new_personnel.suffix!=='Jr.' && 
                                    new_personnel.suffix  !== 'Sr.' && new_personnel.suffix !== 'II'">Other
                                    </option>
                                </select>
                                <input v-if="listenForOther" type="text" v-model="new_personnel.suffix"
                                    class="form-control" placeholder="Please Specify">
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
    name: 'PersonnelFormPage',
    props: ['personnel'],
    data() {
        return {
            new_personnel: {
                suffix: !this.personnel ? '' : this.personnel.suffix,
                first_name: !this.personnel ? '' : this.personnel.first_name,
                middle_name: !this.personnel ? '' : this.personnel.middle_name,
                last_name: !this.personnel ? '' : this.personnel.last_name,
                type: !this.personnel ? 'active' : this.personnel.type,
                employee_number: !this.personnel ? '' : this.personnel.employee_number,
                id: !this.personnel ? 0 : this.personnel.id,

            }
        }
    },
    methods: {
        updatePersonnel(personnel) {
            this.$emit('update-personnel', personnel);
        },
        addPersonnel(personnel) {
            this.$emit('add-personnel', personnel);
        },
        actionShow() {
            this.$emit('action-show');
        },

    },

    computed: {
        listenForOther() {
            if (this.new_personnel.suffix !== 'Jr.' &&
                this.new_personnel.suffix !== 'Sr.' && this.new_personnel.suffix !== 'II' && this.new_personnel.suffix !== '') {
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

.modal-dialog-cs .modal-body {
    width: 500px;
    height: auto;
    margin: auto;
    height: fit-content;
}
</style>