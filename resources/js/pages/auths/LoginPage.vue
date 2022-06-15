<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 style="display:inline; float:left; max-width:40%;">Login</h5>
                        <!-- put this fontawesome user logo at the right side -->
                        <h3 class="text-secondary" style="position:absolute; right:0; margin-right:0.9rem;"><i
                                class="fas fa-user"></i></h3>
                    </div>

                    <div class="card-body" :style="formButton.styleCursor">
                        <form role="form" @submit.prevent="login">


                            <div class="form-group row">
                                <!-- username -->
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-6">
                                    <input :disabled="formButton.disabled" class="form-control" v-model="username"
                                        placeholder="username" name="username" type="text" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- password -->
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input :disabled="formButton.disabled" class="form-control" v-model="password"
                                        placeholder="password" name="password" type="password" value="">
                                </div>
                            </div>
                            <!-- <div class="checkbox">
                                    <label>
                                        <input name="remember" v-model="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
                            <div class="form-group row mb-0">
                                <div class="col-md-3 offset-md-4">
                                    <button :disabled="formButton.disabled" type="submit" :class="formButton.class"
                                        class="btn btn-block">{{formButton.text}}</button>
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
    name: 'LoginPage',
    data() {
        return {
            username: '',
            password: '',

            formButton:{
                text: 'Login',
                class: 'btn-danger',
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
                _token: this._token
            })
            .then(({data})=>{
                // use storage to store the token
                // console.log(data)
                localStorage.setItem('token', data.access_token);
                localStorage.setItem('token_type', data.token_type);
                this.$toast.success('Login Successful via Passport: ', 'Success');
                // request user data via axioss
                axios.get('/user', {
                    headers: {
                        'Authorization': data.token_type + ' ' + data.access_token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).then(({data})=>{
                    // store user data in storage
                    localStorage.setItem('user', JSON.stringify(data));
                    this.$store.commit('setUser', data);
                    this.$store.commit('setIsAuthenticated', true);

                    window.Auth.loggedIn = true;
                    window.Auth.user = data;
                    
                    // redirect to a route refereced
                    // get params from the url for redirect
                    const redirect = this.$route.query.redirect;
                    if(redirect){
                        this.$router.push(redirect);
                    }else{
                        this.$router.push('/');
                    }

                }).catch(err=>{
                    console.log(err);
                });
            })
            .catch((error) => {
                // use vue-izitoast to show error message
                // display all the errors in the form
                this.$toast.error(error.response.data.message)

            }).finally(()=>{
                this.formButton.text = 'Login';
                this.formButton.class = 'btn-danger';
                this.formButton.disabled = false;
                this.formButton.styleCursor = {
                    cursor: 'pointer'
                };
            })
        }
    }
}
</script>
