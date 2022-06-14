<template>
    <div class="container">
        <!-- Registration of User using bootstrap -->
        <div class="row">
            <div class="col-md-6 col-offset-3" style="margin:0 auto;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title text-danger" style="text-align: center;"><i class="fa-solid fa-user"></i>
                        </h1>
                    </div>
                    <div class="panel-body" :style="formButton.styleCursor">
                        <!-- form for verifying Membership Number before Registration -->
                        <form role="form" @submit.prevent="verifyNumberInput">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" v-model="membership_number" placeholder="Employee Number/Student Number"
                                        name="membershipNumber" type="text" autofocus>
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
                                    <input :disabled="true"  class="form-control" 
                                        placeholder="Name" name="name" type="text" :value="fullName" >
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
                                        name="password_confirmation" type="password" value="">
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
                status: '',
            },

            user_full_name:{
                first_name: '',
                last_name: '',
                middle_name: '',
                name_suffix: '',
            },

            formButton: {
                text: 'Register',
                class: 'btn-secondary',
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
            this.formButton.disabled = true;
            this.formButton.styleCursor.cursor = 'wait';
            this.formButton.text = 'Registering...';
            this.formButton.class = 'btn-warning';
        },

        verifyNumberInput(){
            axios.post('/verify_srn', {
                membership_number: this.user.membership_number,
                _token: this._token,
            }).then(({data})=>{
                console.log(data)
            }).catch((error)=>{
                console.log(error)
            }).finally(()=>{
                this.formButton.disabled = false;
                this.formButton.styleCursor.cursor = 'pointer';
                this.formButton.text = 'Register';
                this.formButton.class = 'btn-secondary';
            })
        }
    },

    computed:{
        fullName(){
            return this.user_full_name.first_name + ' ' +
             this.user_full_name.middle_name + ' ' +
              this.user_full_name.last_name+ ' ' +
              this.user_full_name.name_suffix;
        }
    }
}

</script>
