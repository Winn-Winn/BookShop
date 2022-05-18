<template>
    <AppLayout>
        <div class="mask d-flex align-items-center h-100 gradient-custom-3 mt-3">
            <div class="container h-100">
                <p class="alert alert-danger" role="alert" v-for="(value,index) in errors" :key="index">
                {{value.slice('')[0].split('/')[1]}} {{value.slice('')[0].split('/')[0]}}
                </p>
                <div class="alert alert-danger" role="alert" v-if="error_message">
                    {{ error_message }}
                </div>
                <div class="alert alert-success" role="alert" v-if="successStatus">
                    {{ successMessage }}
                </div>
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Create Book</h2>
                                <form>
                                    <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1cg">title</label>
                                    <input type="text" id="form3Example1cg" class="form-control form-control-lg" v-model="title" />
                                    </div>

                                    <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3cg">Description</label>
                                    <textarea  id="form3Example4cg" class="form-control form-control-lg" style="height: 150px" v-model="description"></textarea>
                                    </div>

                                    <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example4cg">Author</label>
                                    <input type="text" id="form3Example4cg" class="form-control form-control-lg" v-model="author"/>
                                    </div>

                                    <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example4cg">Price</label>
                                    <input type="text" id="form3Example4cg" class="form-control form-control-lg" v-model="price"/>
                                    </div>

                                    <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example4cg">Number of Books</label>
                                    <input type="text" id="form3Example4cg" class="form-control form-control-lg" v-model="books_num"/>
                                    </div>

                                    <div class="d-flex justify-content-around">
                                        <button type="button"
                                            class="btn btn-secondary btn-block btn-lg gradient-custom-4" @click="goToList">View List</button>
                                        <button type="button"
                                            class="btn btn-primary btn-block btn-lg gradient-custom-4" @click="createBook">Post Book</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    name: 'BookCreate',
    components: {
        AppLayout
    },
    data() {
        return {
            book_id:'',
            user_id: '',
            title: '',
            description: '',
            author: '',
            price: '',
            books_num: '',
            errors:[],
            error_message:'',
            errorStatus:false,
            successStatus:false,
            successMessage:'',
        }
    },
    mounted() {
        this.book_id = this.$route.params.id;
        this.getBookData();
    },
    methods: {
        getBookData() {
            apiService.getBookData(this.book_id)
            .then(result => {
                if(result.status == 'success'){
                    this.user_id = result.book.user_id;
                    this.title = result.book.title;
                    this.description = result.book.description;
                    this.author = result.book.author;
                    this.price = result.book.price;
                    this.books_num = result.book.number_of_books;
                    this.errorStatus = false;
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        createBook() {
            var request_data = {
                user_id: this.user_id,
                title: this.title,
                description: this.description,
                author: this.author,
                price: this.price,
                books_num: this.books_num
            };
            apiService.createBook(request_data)
            .then(result => {
                if(result.status == 'success') {
                    this.successStatus = true;
                    this.successMessage = result.message;
                }
            })
            .catch(error => {
                console.log(error)
                this.errorStatus = true
                this.successStatus = false
                this.errors = [];
                this.error_message ='';
                if(error.errors) {
                    this.errors = error.errors;
                } else {
                    this.error_message = error.message;
                }
            });
        },
        goToList() {
            this.$router.push({ name: "BookList"});
        }
    }
}
</script>
