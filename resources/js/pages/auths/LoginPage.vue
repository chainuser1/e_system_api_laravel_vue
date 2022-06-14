<template>

    <div class="container">
        <!-- create a Login Form using bootstrap -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin:0 auto;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title text-danger" style="text-align: center;"><i class="fa-solid fa-user"></i></h1>
                    </div>
                    <div class="panel-body" :style="formButton.styleCursor" :disabled="formButton.disabled">
                        <form role="form" @submit.prevent="login">

                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" v-model="username" placeholder="username"
                                        name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" v-model="password" placeholder="Password"
                                        name="password" type="password" value="">
                                </div>
                                <!-- <div class="checkbox">
                                    <label>
                                        <input name="remember" v-model="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
                                <button :style="formButton.styleCursor" :disabled="formButton.disabled" type="submit"
                                    :class="formButton.class" class="btn btn-lg  btn-block">{{formButton.text}}</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name: 'LoginPage',
    data() {
        return {
            username: '',
            password: '',
            remember: false,
            errors: [],
            success: false,
            message: '',

            formButton:{
                text: 'Login',
                class: 'btn-success',
                disabled: false,
                styleCursor: {
                    cursor: 'pointer'
                }   
            },
            _token: window.Laravel.csrfToken,
        }   
    },
    methods:{
        login(){
            this.formButton.text = 'Logging in...';
            this.formButton.class = 'btn-secondary';
            this.formButton.disabled = true;
            this.formButton.styleCursor = {
                cursor: 'wait'
            };
           axios.post('/login', {
                username: this.username,
                password: this.password,
                // _token: this._token
            })
            .then(({data})=>{
                this.$toast.success("Login Successfully","Success")
                console.log(window.Auth)
            })
            .catch((error) => {
                // use vue-izitoast to show error message
                this.$toast.error(error.response.data.message, 'Error',{

                })
            }).finally(()=>{
                this.formButton.text = 'Login';
                this.formButton.class = 'btn-success';
                this.formButton.disabled = false;
                this.formButton.styleCursor = {
                    cursor: 'pointer'
                };
            })
        }
    }
}
</script>
