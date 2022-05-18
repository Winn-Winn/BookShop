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
                <h2>Order History</h2>
                <div class="col-lg-12">
                    <form class="row">
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1 mb-3">
                            <input type="text" class="form-control" placeholder="Name" ref="name" :value="name" required>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1 mb-3">
                            <input type="text" class="form-control" placeholder="Address" ref="address" :value="address" required>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1 mb-3">
                            <input type="text" class="form-control" placeholder="09-123456789" ref="phone" :value="phone" required>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1 mb-3">
                            <select class="form-control custom-select" ref="payment" :value="payment" required>
                                <option value=""></option>
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                            <button type="button" class="btn btn-primary wrn-btn" @click="Save">Save</button>
                        </div>
                    </form>
                </div>
                <div class="mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in itemList" :key="order.id">
                                <td>{{ order.name }}</td>
                                <td>{{ order.qty }}</td>
                                <td>{{ order.total_prices }}</td>
                                <td>{{ name }}</td>
                                <td>{{ address }}</td>
                                <td>{{ phone }}</td>
                                <td>{{ payment }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <div>
                        <button type="button"
                            class="btn btn-outline-secondary shadow mx-3" @click="goToList">View Book List</button>
                        <button type="button"
                            class="btn btn-outline-danger shadow" @click="Order">Order</button>
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
    name: "OrderList",
    components: {
        AppLayout
    },
    data() {
      return {
        name: '',
        address: '',
        phone: '',
        payment: '',
        title: '',
        total_price: '',
        itemList: [],
        auth_data: '',
        token: '',
        user_id: '',
        error_message:'',
        errorStatus:false,
        successStatus:false,
        successMessage:'',
      };
    },
    mounted() {
        this.getAuthData();
    },
    methods: {
        getAuthData() {
            this.auth_data =  apiService.getAuthData();
            this.token = this.auth_data.token;
            this.user_id = this.auth_data.user_id;
            this.role = this.auth_data.role;
        },
        goToList() {
            this.$router.push({ name: "BookList"});
        },
        Save() {
            this.name = this.$refs.name.value;
            this.address = this.$refs.address.value;
            this.phone = this.$refs.phone.value;
            this.payment = this.$refs.payment.value;
            var request_data = {
                user_id: this.user_id
            }
            apiService.getOrderList(request_data)
            .then(result => {
                if(result.status == 'success'){
                    this.successStatus = true;
                    this.successMessage = result.message;
                    this.itemList = result.orders;
                }
            })
            .catch(error => {
                console.log(error);
            });
            
        },
        Order() {
            var request_data = {
                user_id : this.user_id
            }
            apiService.Order(request_data)
            .then(result => {
                if(result.status == 'success'){
                    this.$router.go();
                    this.successStatus = true;
                    this.successMessage = result.message;
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    },
  };
</script>
