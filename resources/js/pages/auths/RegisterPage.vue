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
                        <form role="form" @submit.prevent="register">
                            <fieldset>
                                <div class="form-group">
                                    <input :disabled="formButton.disabled" class="form-control" v-model="username"
                                        placeholder="username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input :disabled="formButton.disabled" class="form-control" v-model="password"
                                        placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <input :disabled="formButton.disabled" class="form-control"
                                        v-model="password_confirmation" placeholder="Password Confirmation"
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
            username: '',
            password: '',
            password_confirmation: '',

            formButton: {
                text: 'Register',
                class: 'btn-secondary',
                disabled: true,
                styleCursor: {
                    cursor: 'pointer'
                }
            }
        }
    },
    methods: {
        register() {
            this.formButton.disabled = true;
            this.formButton.styleCursor.cursor = 'wait';
            this.formButton.text = 'Registering...';
            this.formButton.class = 'btn-warning';
        }
    }
}

</script>
