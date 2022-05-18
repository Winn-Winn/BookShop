<template>
    <div class="container h-100">
        <nav class="row" role="navigation" aria-label="main navigation">
            <div class="col-lg-3"><router-link :to="{ name: 'BookList'}">Home</router-link></div>
            <div class="col-lg-3">
                <router-link :to="'/cart/' + user_id" class="font-weight-normal text-primary d-block text-right" style="font-size: 15px;">
                    <p>Total cart items: {{ cart_count }}</p>
                </router-link>
            </div>
            <div class="col-lg-3">
                <span v-if="token" class="d-flex justify-content-start">
                    <p class="mx-3">{{ user_name }} :</p>
                    <a href="javascript:void(0)" @click="logout">Logout</a>
                </span>
                <span v-else>
                    <router-link :to="{ name: 'UserCreate'}">Register</router-link>  |
                    <router-link :to="{ name: 'LoginData'}">Login</router-link>
                </span>
            </div>
        </nav>
    </div>
</template>
<script>
import { APIService } from "@/apiService.js";
const apiService = new APIService();

export default {
  name: "HeaderPart",
  data() {
    return {
        auth_data: '',
        token: '',
        user_name: '',
        user_id: '',
        cart_count: 0,
    };
  },
  mounted () {
      this.getAuthData();
      this.getCartList();
  },
  methods: {
    getAuthData() {
        this.auth_data =  apiService.getAuthData();
        this.token = this.auth_data.token;
        this.user_name = this.auth_data.user_name;
        this.user_id = this.auth_data.user_id;
    },
    getCartList() {
        apiService.getCartList(this.user_id)
        .then(result => {
            if(result.status == 'success'){
                this.cart_count = result.cartList.length;
            }
        })
        .catch(error => {
            console.log(error);
        });
    },
    logout() {
        localStorage.clear();
        window.location.reload();
        window.location.href = '/login';
    },
  },
  computed: {
  },
};
</script>
