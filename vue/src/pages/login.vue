<template>
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <p class="alert alert-danger" role="alert" v-for="(value,index) in errors" :key="index">
            {{value.slice('')[0].split('/')[1]}} {{value.slice('')[0].split('/')[0]}}
            </p>
            <div class="alert alert-danger" role="alert" v-if="errorStatus">
                {{ error_message }}
            </div>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-uppercase text-center mb-5">Account Login</h2>
                            <form>
                                <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example3cg">Email</label>
                                <input type="email" id="form3Example3cg" class="form-control form-control-lg" v-model="email"/>
                                </div>

                                <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example4cg">Password</label>
                                <input type="password" id="form3Example4cg" class="form-control form-control-lg" v-model="password"/>
                                </div>

                                <div class="d-flex justify-content-center">
                                <button type="button"
                                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" @click="login">Login</button>
                                </div>

                                <p class="text-center text-muted mt-5 mb-0">If you have not registered
                                    <router-link
                                        :to="{ name: 'UserCreate' }"
                                        class="font-weight-normal text-primary d-block text-right"
                                        style="font-size: 15px;"
                                    >
                                    <u>Register here</u>
                                    </router-link>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { APIService } from "@/apiService.js";
const apiService = new APIService();

export default {
    name: 'LoginPage',
    data() {
        return {
            email: '',
            password: '',      
            errors:[],
            error_message:'',
            errorStatus:false,
        }
    },
    mounted() {
        
    },
    methods: {
        login() {
            var request_data = {
                email: this.email,
                password: this.password
            };
            apiService.loginUser(request_data)
            .then(result => {
                if(result.success) {
                    var auth_data = {
                        token : result.data.token,
                        user_name : result.data.name,
                        user_id : result.data.user_id,
                        role : result.data.role,
                    }
                    apiService.setAuthData(auth_data);
                    this.$router.push({
                        name: "BookList",
                    });
                } else {
                    this.errorStatus = true;
                    this.error_message = result.message;
                }
            })
            .catch(error => {
                console.log(error)
                this.errorStatus = true
                this.errors = [];
                this.error_message ='';
                if(error.errors) {
                    this.errors = error.errors;
                } else {
                    this.error_message = error.message;
                    this.error_message_no = error.message_no;
                }
            });
        },
    }
}
</script>
