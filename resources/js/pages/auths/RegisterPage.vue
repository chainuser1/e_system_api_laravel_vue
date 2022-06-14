<template>
    <div class="container">
        <!-- Registration of User using bootstrap -->
        <div class="row">
            <div class="col-md-6 col-offset-3" style="margin:0 auto;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title text-danger" style="text-align: center;"><i class="fa-solid fa-user"></i>
                        </h1>
                        <!-- loading  -->
                    </div>
                    <div class="panel-body" :style="formButton.styleCursor">
                        <!-- form for verifying Membership Number before Registration -->
                        <form role="form" @submit.prevent="verifyNumberInput">
                            <fieldset>
                                <div class="form-group">
                                    <input :disabled="verify.state" class="form-control"
                                        v-model="user.membership_number" placeholder="Employee Number/Student Number"
                                        name="membershipNumber" type="text" autofocus>
                                    <!--                                     if verify.found =='true' then show the following -->
                                    <!-- font-awesomee check green -->
                                    <i style="display:inline;" v-if="verify.found==1"
                                        class="fa-solid fa-check text-success"></i>
                                    <!-- font-awesomee check red -->
                                    <i style="display:inline;" v-else-if="verify.found==0"
                                        class="fa-solid fa-times text-danger"></i>
                                    <!-- else  -->
                                    <!-- while loading -->
                                    <i style="display:inline;" v-if="verify.loading"
                                        class="fa-solid fa-spinner fa-spin"></i>
                                </div>
                            </fieldset>
                        </form>
                        <form role="form" @submit.prevent="register">
                            <fieldset>
                                <div class="form-group">
                                    <input :disabled="formButton.disabled" class="form-control" v-model="user.username"
                                        placeholder="username" name="username" type="text" autofocus>

                                </div>
                                <!-- name -->
                                <div class="form-group">
                                    <input class="form-control" disabled placeholder="Name" name="name" type="text"
                                        v-model="user.name">
                                </div>
                                <!-- email -->
                                <div class="form-group">
                                    <input :disabled="formButton.disabled" class="form-control" v-model="user.email"
                                        placeholder="Email" name="email" type="email">
                                </div>

                                <div class="form-group">
                                    <input :disabled="formButton.disabled" class="form-control" v-model="user.password"
                                        placeholder="Password" name="password" type="password" value="">
                                </div>

                                <div class="form-group">
                                    <input :disabled="formButton.disabled" class="form-control"
                                        v-model="user.password_confirmation" placeholder="Password Confirmation"
                                        name="password_confirmation" type="password">
                                    <!-- if password_match == false -->
                                    <i style="display:inline;" v-if="password_match==false"
                                        class="fa-solid fa-times text-danger"></i>
                                    <!-- else  -->
                                    <i style="display:inline;" v-else class="fa-solid fa-check text-success"></i>
                                </div>
                            </fieldset>
                            <button :style="formButton.styleCursor" :disabled="formButton.disabled" type="submit"
                                :class="formButton.class" class="btn btn-lg  btn-block">{{formButton.text}}</button>
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
            })
            .catch(error => {
                this.formButton.disabled = false;
                this.formButton.styleCursor.cursor = 'pointer';
                this.formButton.text = 'Register';
                this.formButton.class = 'btn-danger';
                // use for loop to display all errors, with timeout of 2 seconds
                for(let error of error.response.data.errors){
                    this.toast.error(error,'Error')
                }
            });
        },

        verifyNumberInput(){
            // set loading to true for axios
            this.verify.loading = true;
            axios.post('/verify_srn', {
                membership_number: this.user.membership_number,
                _token: this._token,
            }).then((res)=>{

                let {data} = res.data;
                // exclude middle name and suffix if empty to create name
                this.user.name = data.first_name + ' ' + data.last_name;
                this.user.role = res.data.type
                this.formButton.disabled = false;
                this.verify.state = true;
                this.verify.found = 1;
                this.formButton.text = "Register as "+this.user.role
            }).catch((error)=>{
                this.verify.found = 0;
                this.$toast.error(error.response.data.message);
            }).finally(()=>{
                this.formButton.disabled = false;
                this.formButton.styleCursor.cursor = 'pointer';
                this.formButton.text = 'Register';
                this.formButton.class = 'btn-secondary';
                this.verify.loading = false;
            })
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
        }
    },

    

   
}

</script>
<style  scoped>
  /* set float to left only for input.form-control with an <i> after it */
  /* ignore the other input */
    input.form-control[name="confirm_password"],input.form-control[name="membershipNumber"] {
        float: left;
        
    }
    
</style>