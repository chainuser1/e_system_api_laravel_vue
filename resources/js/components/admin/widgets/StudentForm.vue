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
                <form
                    @submit.prevent="this.student !== null ? updateStudent(this.new_student) : addStudent(this.new_student)">
                    <!-- <input type="hidden" :value ="updateStudent"/> -->
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="this.new_student.name" id="name"
                                    placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" v-model="this.new_student.price" id="price"
                                    placeholder="Enter price">
                            </div>
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="text" class="form-control" v-model="this.new_student.stock" id="stock"
                                    placeholder="Enter stock">
                            </div>
                           
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" v-model="this.new_student.description" id="description"
                                    placeholder="Enter description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger color-secondary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <student-form v-if="this.action=='show'" v-bind:student="addOrUpdateStudent" v-on:add-student="addStudent"
             v-on:update-student="editStudent"
            v-on:action-show="actionShow"></student-form>
    </div>
</template>
<script>
export default {
    name: 'StudentForm',
    props: ['student', ''],
    components:{

    },
    data() {
        return {
            new_student: {
                id: this.student !== null ? this.student.id : '0',
                name: this.student !== null ? this.student.name : '',
                price: this.student !== null ? this.student.price : '',
                stock: this.student !== null ? this.student.stock : '',
                Id: this.student !== null ? this.student.Id : '',
                description: this.student !== null ? this.student.description : '',
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