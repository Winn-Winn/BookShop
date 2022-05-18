<template>
    <AppLayout>
        <div class="mask d-flex align-items-center h-100 gradient-custom-3 mt-3">
            <div class="container h-100">
                <div class="alert alert-danger" role="alert" v-if="error_message">
                    {{ error_message }}
                </div>
                <div class="lert alert-success" role="alert" v-if="successStatus">
                    {{ successMessage }}
                </div>
                <h2>Shopping Cart</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(cart, idx) in cartList" :key="idx">
                            <td>{{ cart.name }}</td>
                            <td class="col-1">
                                <input type="number" min="1" class="form-control quantity update-cart" v-model="cart.qty" />
                            </td>
                            <td>{{ cart.price }}</td>
                            <td><button type="button" class="btn btn-danger" @click="Remove(cart.id)">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <div>
                        <button type="button"
                            class="btn btn-outline-secondary shadow mx-3" @click="goToList">Continue Shopping</button>
                        <button type="button"
                            class="btn btn-outline-danger shadow" @click="emptyCart">Empty Cart</button>
                    </div>
                    <div>
                        <p v-if="calculateTotalPrices">Total Prices : {{ calculateTotalPrices }} MMK</p>
                        <p v-else>Total Prices : 0 </p>
                    </div>
                    <div>
                        <button type="button"
                            class="btn btn-outline-secondary shadow mx-3" @click="update">Update Cart</button>
                        <button type="button"
                            class="btn btn-outline-secondary shadow" @click="checkout">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
  import AppLayout from "@/components/layouts/Layout.vue";
  import { APIService } from "@/apiService.js";
  const apiService = new APIService();

  export default {
    name: "CartList",
    components: {
        AppLayout
    },
    data() {
      return {
        user_id: '',
        cartList: [],
        total_prices: 0,
        error_message:'',
        errorStatus:false,
        successStatus:false,
        successMessage:'',
      };
    },
    mounted() {
        this.user_id = this.$route.params.user_id;
        this.getCartList();
    },
    methods: {
        goToList() {
            this.$router.push({ name: "BookList"});
        },
        getCartList() {
            apiService.getCartList(this.user_id)
            .then(result => {
                if(result.status == 'success'){
                    this.cartList = result.cartList;
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        update() {
            var request_data = {
                cartList : this.cartList
            };
            console.log(request_data);
            apiService.updateCart(request_data)
            .then(result => {
                if(result.status == 'success'){
                    this.successStatus = true;
                    this.successMessage = result.message;
                    this.errorStatus = false;
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        Remove(id) {
            console.log(id);
            apiService.removeCart(id)
            .then(result => {
                if(result.status == 'success'){
                    this.successStatus = true;
                    this.successMessage = result.message;
                    this.$router.go();
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        emptyCart() {
            var request_data = {
                user_id : this.user_id
            }
            apiService.clearAllCart(request_data)
            .then(result => {
                if(result.status == 'success'){
                    this.successStatus = true;
                    this.successMessage = result.message;
                    this.$router.go();
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        checkout() {
            var request_data = {
                cartList : this.cartList
            };
            apiService.checkout(request_data)
            .then(result => {
                if(result.status == 'success'){
                    this.$router.push({ name: "OrderList" });
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
    },
    computed: {
        calculateTotalPrices () {
            let total_prices = 0;
            this.cartList.forEach((cart) => {
                total_prices += cart.qty * cart.price;
            });  
            return total_prices;
        }
    }
  };
</script>
