<template>
    <div class="mask d-flex align-items-center h-100 gradient-custom-3 mt-3">
        <div class="container h-100">
            <p class="alert alert-danger" role="alert" v-for="(value,index) in errors" :key="index">
            {{value.slice('')[0].split('/')[1]}} {{value.slice('')[0].split('/')[0]}}
            </p>
            <div class="alert alert-danger" role="alert" v-if="errorStatus">
                {{ error_message_no }} {{ error_message }}
            </div>
            <div class="lert alert-success" role="alert" v-if="successStatus">
                {{ successMessage }}
            </div>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-uppercase text-center mb-5">Create an account</h2>
                            <form>
                                <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example1cg">Name</label>
                                <input type="text" id="form3Example1cg" class="form-control form-control-lg" v-model="name" />
                                </div>

                                <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example3cg">Email</label>
                                <input type="email" id="form3Example3cg" class="form-control form-control-lg" v-model="email"/>
                                </div>

                                <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example4cg">Password</label>
                                <input type="password" id="form3Example4cg" class="form-control form-control-lg" v-model="password"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="checkbox" class="mr-1" v-model="role" :checked="this.isChecked == true" /> Admin
                                </div>

                                <div class="d-flex justify-content-center">
                                <button type="button"
                                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" @click="regist">Register</button>
                                </div>

                                <p class="text-center text-muted mt-5 mb-0">Have already an account? 
                                    <router-link
                                        :to="{ name: 'LoginData' }"
                                        class="font-weight-normal text-primary d-block text-right"
                                        style="font-size: 15px;"
                                    >
                                    <u>Login here</u>
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
    name: 'UserPage',
    data() {
        return {
            name: this.$route.params.name,
            role: this.$route.params.role,
            email: this.$route.params.email,
            password: this.$route.params.password,
            isChecked : false,
            errors:[],
            error_message:'',
            errorStatus:false,
            successStatus:false,
            successMessage:'',
        }
    },
    mounted() {
        if(this.role == 1) {
            this.isChecked = true;
        }
    },
    methods: {
        regist() {
            var request_data = {
                name: this.name,
                role: this.role,
                email: this.email,
                password: this.password
            };
            apiService.createUser(request_data)
            .then(result => {
                if(result.success == true) {
                    this.$router.push({
                        name: "LoginData",
                    });
                }
            })
            .catch(error => {
                console.log(error)
            });
        },
    }
}
</script>
