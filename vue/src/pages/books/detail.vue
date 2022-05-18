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
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <h2>Book Detail</h2>
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h3>{{ title }}</h3>
                                <p>Wroted by : {{ author }}</p>
                                <p class="border-bottom pb-3">{{ description }}</p>
                                <h4 class="border-bottom pb-3">current price: <span>{{ price }} MMK</span></h4>
                                <form>
                                    <div class="form-outline mb-2">
                                        <input type="checkbox" class="mr-1" v-model="react" :checked="this.isChecked == true" /> React to this Book
                                    </div>
                                    <div class="d-flex justify-content-start mt-3">
                                        <label class="form-label col-3 align-middle" for="form3Example1cg">Add a Comment :</label>
                                        <input type="text" id="form3Example1cg" class="form-control form-control-lg" v-model="new_comment" />
                                        <button type="button" class="btn btn-success btn-block gradient-custom-4 mx-3" v-if="new_comment || react" @click="addComment">send</button>
                                    </div>
                                </form>
                                <div class="mt-3">
                                    <ul class="list-group list-group-flush">
                                        <div class="d-flex justify-content-between border-bottom">
                                            <h5>Comments: {{ cmt_count }}</h5>
                                            <h5>Reaction: {{ react_count }}</h5>
                                        </div>
                                        <li class="list-group-item d-flex justify-content-between" v-for="cmt in comments" :key="cmt.id">
                                            <p>{{ cmt.comment }}</p>
                                            <span v-if="cmt.react != null">Liked</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <div class="d-flex justify-content-start">
                                        <button type="button" class="btn btn-success btn-block btn-lg gradient-custom-4" v-if="inCart" @click="goToCartList(user_id)">In Cart</button>
                                        <button type="button" class="btn btn-success btn-block btn-lg gradient-custom-4" v-else @click="addToCart">Add to cart</button>
                                    </div>
                                    <button type="button" class="btn btn-success btn-block btn-lg gradient-custom-4" @click="goToBookList">Back</button>
                                </div>
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
    name: "BookDetail",
    components: {
        AppLayout
    },
    data() {
      return {
        book_id: '',
        user_id: '',
        title: '',
        description: '',
        author: '',
        price: '',
        books_num: '',
        cmt_count: 0,
        react_count: 0,
        comment: '',
        reaction: '',
        name: '',
        qty: '',
        prices: '',
        auth_data: '',
        new_comment: '',
        react: '',
        isChecked: false,
        inCart: false,
        comments: [],
        errors:[],
        error_message:'',
        errorStatus:false,
        successStatus:false,
        successMessage:'',
      };
    },
    mounted() {
        this.book_id = this.$route.params.id;
        this.getAuthData();
        this.getDetailData();
    },
    methods: {
        getAuthData() {
            this.auth_data =  apiService.getAuthData();
        },
        goToBookList() {
            this.$router.push({ name: "BookList"});
        },
        goToCartList(user_id) {
            this.$router.push({ path: `/cart/${user_id}` })
        },
        getDetailData() {
            apiService.getDetailData(this.book_id)
            .then(result => {
                if(result.status == 'success'){
                    this.book_id = result.book.id;
                    this.user_id = result.book.user_id;
                    this.title = result.book.title;
                    this.description = result.book.description;
                    this.author = result.book.author;
                    this.price = result.book.price;
                    this.books_num = result.book.books_num;
                    this.comment_num = result.book.comment_num;
                    this.react_num = result.book.react_num;
                    this.errorStatus = false;
                    this.getComments();
                    this.getCartDataByBook();
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        addToCart() {
            if(this.auth_data.token) {
                var request_data = {
                    book_id: this.book_id,
                    user_id : this.auth_data.user_id,
                };
                apiService.addToCart(request_data)
                .then(result => {
                    if(result.status == 'success'){
                        this.inCart = true;
                        if(confirm('Keep Shopping')) {
                            this.successStatus = true;
                            this.successMessage = result.message;
                            return;
                        } else {
                            this.$router.push({ path: `/cart/${this.auth_data.user_id}` })
                        }
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            } else {
                window.location.href = '/login';
            }
        },
        getCartDataByBook() {
            var request_data = {
                book_id: this.book_id,
                user_id : this.auth_data.user_id,
            };
            apiService.getCartDataByBook(request_data)
            .then(result => {
                if(result.status == 'success'){
                    if(result.cartByBookID.length != 0) {
                        this.inCart = true;
                    } else {
                        this.inCart = false;
                    }
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getComments() {
            var request_data = {
                book_id : this.book_id
            }
            apiService.getComments(request_data)
            .then(result => {
                if(result.status == 'success'){
                    this.comments = result.commentList;
                    this.cmt_count = result.cmt_count;
                    this.react_count = result.react_count;
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        addComment() {
            var request_data = {
                book_id : this.book_id,
                user_id : this.auth_data.user_id,
                comment : this.new_comment,
                react: this.react
            }
            apiService.addComment(request_data)
            .then(result => {
                if(result.status == 'success'){
                    console.log(result);
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
