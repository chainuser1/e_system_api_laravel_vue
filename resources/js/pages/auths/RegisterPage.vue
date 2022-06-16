<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 style="display:inline; float:left; max-width:40%;">Register</h5>
                        <!-- put this fontawesome user logo at the right side -->
                        <h3 class="text-secondary" style="position:absolute; right:0; margin-right:0.9rem;"><i class="fas fa-user"></i></h3>
                    </div>
                    <div class="card-body" :style="formButton.styleCursor">
                        <!-- form for verifying Membership Number before Registration -->
                        <form role="form" @submit.prevent="verifyNumberInput">

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="membership_number">Employee
                                    No./SRN</label>
                                <div class="col-md-4">

                                    <input :disabled="verify.state" type="text" class="form-control"
                                        id="membership_number" v-model="user.membership_number"
                                        placeholder="Membership Number">
                                    <a href="#" class="nav-link text-danger" @click.prevent="resetForm">Not you?</a>
                                </div>
                                <div class="col-md-3">
                                    <!--if verify.found =='true' then show the following -->
                                    <!-- font-awesomee check green -->
                                    <i style="display:inline;" v-show="verify.loading"
                                        class="fa-solid fa-spinner fa-spin"></i>
                                    <i style="display:inline;" v-if="verify.found==1"
                                        class="fa-solid fa-check text-success"></i>
                                    <!-- font-awesomee check red -->
                                    <i style="display:inline;" v-else-if="verify.found==0"
                                        class="fa-solid fa-times text-danger"></i>
                                    <!-- else  -->
                                    <!-- while loading -->

                                </div>


                            </div>

                        </form>
                        <form role="form" @submit.prevent="register">

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="username">Username</label>
                                <div class="col-md-6">
                                    <input :disabled="formButton.disabled" type="text" class="form-control"
                                        :style="formButton.styleCursor" id="username" v-model="user.username"
                                        placeholder="Username">
                                </div>

                            </div>
                            <!-- name -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="name">Name</label>
                                <div class="col-md-6">
                                    <input :disabled="formButton.disabled" type="text" class="form-control" id="name"
                                        :style="formButton.styleCursor" v-model="user.name" placeholder="Name">
                                </div>
                            </div>
                            <!-- email -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="email">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input :disabled="formButton.disabled" type="email" class="form-control" id="email"
                                        :style="formButton.styleCursor" v-model="user.email"
                                        placeholder="E-Mail Address">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="password">Password</label>
                                <div class="col-md-6">
                                    <input :disabled="formButton.disabled" type="password" class="form-control"
                                        :style="formButton.styleCursor" id="password" v-model="user.password"
                                        placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="password_confirmation">Confirm
                                    Password</label>
                                <div class="col-md-5">
                                    <input :style="formButton.styleCursor" :disabled="formButton.disabled"
                                        type="password" class="form-control" id="password_confirmation"
                                        v-model="user.password_confirmation" placeholder="Confirm Password">
                                </div>
                                <div class="col-md-2">
                                    <!-- if password_match == false -->
                                    <i style="display:inline;" v-if="password_match==false"
                                        class="fa-solid fa-times text-danger"></i>
                                    <!-- else  -->
                                    <i style="display:inline;" v-else class="fa-solid fa-check text-success"></i>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button :style="formButton.styleCursor" :disabled="formButton.disabled"
                                        type="submit" class="btn" :class="formButton.class">
                                        {{formButton.text}}
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


    </div>
</template>

<script>
export default {
    name: 'RegisterPage',
    data() {
        return {
            user:{
                membership_number: '',
                username: '',
                password: '',
                password_confirmation: '',
                name: '',
                email: '',
                role: '',
                
            },
            password_match: false,

            verify: {
                state: false,
                found: -1,
                loading:false
            },
            
            formButton: {
                text: 'Register',
                class: 'btn-danger',
                disabled: true,
                styleCursor: {
                    cursor: 'pointer'
                }
            },
            _token: window.Laravel.csrfToken,
            
            
        }
    },
    methods: {
        register() {
            // abort if password_match is false
            if (this.password_match == false) {
                return;
            }
            console.log(this.user)
            this.formButton.disabled = true;
            this.formButton.styleCursor.cursor = 'wait';
            this.formButton.text = 'Registering as '+this.user.role;
            this.formButton.class = 'btn-secondary';

            axios.post('/register', {
                // membership_number:this.user.membership_number,
                // name:this.user.name,
                // password:this.user.password,
                // role:this.user.role,
                // email:this.user.email,
                ...this.user,
                _token: this._token,
            }).then(()=>{
                // if registration is successful
                // redirect to login page with success message
                this.$router.push({
                    name: 'login',
    
                })

            })
            .catch(error => {
                this.formButton.disabled = false;
                this.formButton.styleCursor.cursor = 'pointer';
                this.formButton.text = 'Register';
                this.formButton.class = 'btn-danger';
                // use for loop to display all errors, with timeout of 2 seconds
                console.log(error.response.data.errors)
            });
        },

        verifyNumberInput(){
            // set loading to true for axios
            this.verify.loading = true;
            this.formButton.styleCursor.cursor = 'wait';
            axios.post('/verify_srn', {
                membership_number: this.user.membership_number,
                _token: this._token,
            }).then((res)=>{

                let {data} = res.data;
                // console.log(data)
                // exclude middle name and suffix if empty to create name
                this.user.name = data.first_name + ' ' + data.last_name
                + (data.middle_name ? ' ' + data.middle_name : '')+ (data.suffix ? ' ' + data.suffix : '');
                this.user.role = res.data.type
                this.formButton.disabled = false;
                this.formButton.styleCursor.cursor = 'pointer';
                this.verify.state = true;
                this.verify.found=1
                this.$toast.success(
                    'You can now register as ' + this.user.role,
                    'Hello! ' + this.user.name,
                    {
                        // top middle
                        position: 'topCenter',
                        duration: 3000
                    }
                    
                );
                

            }).catch((error)=>{
                this.verify.found = 0;
                this.$toast.error(error.response.data.message, 'Error!', {
                    // top middle
                    position: 'topCenter',
                    duration: 3000
                });
                this.formButton.disabled = true;
                //pointer or cursor disabled
                this.formButton.styleCursor.cursor = 'not-allowed';
                
                this.verify.state = false;
                
                this.verify.found = 0;
            }).finally(()=>{
                this.verify.loading = false;
            });
        },

        resetForm(){
            this.user.membership_number = '';
            this.user.username = '';
            this.user.password = '';
            this.user.password_confirmation = '';
            this.user.name = '';
            this.user.email = '';
            this.user.role = '';
            this.verify.state = false;
            this.verify.found = -1;
            this.password_match = false;
            this.formButton.disabled = true;
            this.formButton.styleCursor.cursor = 'pointer';
            this.formButton.text = 'Register';
            this.formButton.class = 'btn-danger';
        }
    },

    // create watchers for vue 2
    watch: {
        user: {
            handler() {
                if(this.user.password.length>7)
                    this.password_match = this.user.password == this.user.password_confirmation;
            },
            deep: true
        },
        
        
    }

    

   
}

</script>
<style  scoped>
  /* set float to left only for input.form-control with an <i> after it */
  /* ignore the other input */
    .divide{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .divide input{
        max-width:90% !important;
    }
    
</style>