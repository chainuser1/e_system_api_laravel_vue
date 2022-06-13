<template>

    <div class="container">
        <!-- create a Login Form using bootstrap -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin:0 auto;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please sign in</h3>
                    </div>
                    <div class="panel-body">
                        <form  @submit.prevent="login">
                           
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" v-model="username" placeholder="username" name="username" type="text"
                                        autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" v-model="password"  placeholder="Password" name="password" type="password"
                                        value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" v-model="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
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
            message: ''
        }   
    },
    methods:{
        login(){
           Axios.post('/login', {
                username: this.username,
                password: this.password,
                remember: this.remember
            })
            .then(({data})=>{
                console.log(data)
            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });
        }
    }
}
</script>
