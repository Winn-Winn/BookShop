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
                <h2>Books List</h2>
                <div class="col-lg-12">
                    <form class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0 mx-1">
                            <input type="text" class="form-control search-slt" placeholder="Title" v-model="title">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0 mx-1">
                            <input type="text" class="form-control search-slt" placeholder="Author" v-model="author">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0 mx-1">
                            <input type="text" class="form-control search-slt" placeholder="Price" v-model="price">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mx-1">
                            <button type="button" class="btn btn-primary wrn-btn" @click="Search">Search</button>
                        </div>
                    </form>
                </div>
                <div class="mt-5">
                    <div class="d-flex justify-content-end mt-3" v-if="role == 1">
                        <input type="file" class="d-none" ref="uploadBtn" @change="onFileChange">
                        <button class="btn btn-outline-secondary shadow mr-3" @click="uploadFile">Upload</button>
                        <button class="btn btn-outline-secondary shadow mx-3" @click="downloadFile">Download</button>
                        <router-link :to="{ name: 'BookCreate'}" class="btn btn-outline-secondary shadow" style="font-size: 15px;">New</router-link>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Price</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="book in items" :key="book">
                                <td>{{ book.title }}</td>
                                <td>{{ book.author }}</td>
                                <td>{{ book.price }}</td>
                                <td class="d-flex justify-content-around">
                                    <router-link
                                        :to="'/book/update/'+ book.id"
                                        class="font-weight-normal text-primary d-block text-right"
                                        style="font-size: 15px;"
                                        v-if="role == 1"
                                    >
                                        <u>Edit</u>
                                    </router-link>
                                    <router-link
                                        :to="'/book/detail/'+ book.id"
                                        class="font-weight-normal text-primary d-block text-right"
                                        style="font-size: 15px;"
                                    >
                                        <u>Detail</u>
                                    </router-link>
                                    <button type="button" class="btn btn-danger wrn-btn" v-if="role == 1" @click="Delete(book)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
    name: "BookList",
    components: {
        AppLayout
    },
    data() {
      return {
        title: '',
        author: '',
        price: '',
        items: [],
        auth_data: '',
        token: '',
        user_id: '',
        role: '',
        import_file:'',
        error_message:'',
        errorStatus:false,
        successStatus:false,
        successMessage:'',
      };
    },
    mounted() {
        this.getAuthData();
        this.getBooks();
    },
    methods: {
        getAuthData() {
            this.auth_data =  apiService.getAuthData();
            this.token = this.auth_data.token;
            this.user_id = this.auth_data.user_id;
            this.role = this.auth_data.role;
        },
        getBooks (request_data) {
            apiService.getBooks(request_data)
            .then(result => {
                if(result.status == 'success'){
                    this.items = result.books;
                    this.errorStatus = false;
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        createBook () {
            this.$router.push({
                name: "BookCreate",
                params: { user_id: this.user_id }
            });
        },
        Search () {
            var request_data = {
                title: this.title,
                author: this.author,
                price: this.price
            }
            this.getBooks(request_data);
        },
        Delete (book) {
            console.log(book);
            if(!confirm('Delete?')){
                return;
            }
            var request_data = {
                book_id: book.id,
                user_id: book.user_id,
            };
            apiService.deleteBook(request_data)
            .then((result) => {
                if (result.status == "success") {
                    this.successStatus = true;
                    this.successMessage = result.message;
                    this.Search();
                }
            })
            .catch((error) => {
                console.log(error);
            });
        },
        uploadFile: function () {
            var answer = window.confirm('Upload file?');
            if (answer) {
            this.isLoading = true;
            setTimeout(() => {
                this.isLoading = false;
            }, 1000)
            this.$refs.uploadBtn.click();
            }
        },
        onFileChange(e) {
            this.import_file = e.target.files[0];
            let formData = new FormData();
            formData.append("import_file", this.import_file);

            apiService.fileUpload(formData)
            .then(result => {
                if(result.status =='success') {
                    this.successStatus = true;
                    this.successMessage = result.message;
                    this.Search();
                } else {
                    this.errorStatus = true;
                }
            })
            .catch(error => {
                console.log(error)
            });
        },
        downloadFile() {
            apiService.fileDownload()
            .then(result => {
                this.errorStatus = false;
                this.download(result);
            }).catch(error => {
                if(error == undefined) {
                    this.errorStatus = true;
                    return
                }
                this.blogErrorMessages(error);
            });
        },
        download(result) {
            if (window.navigator.msSaveBlob) {
                window.navigator.msSaveBlob(new Blob([result]), 'Book.xlsx');
            } else {
                const url = window.URL.createObjectURL(new Blob([result]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'Book.xlsx');
                document.body.appendChild(link);
                link.click();
            }
        },
        blogErrorMessages(error){
            let errormessage;
            if (
                error.request.responseType === 'blob' &&
                error.data instanceof Blob &&
                error.data.type &&
                error.data.type.toLowerCase().indexOf('json') != -1
            ) {
                errormessage = new Promise((resolve, reject) => {
                    let reader = new FileReader();
                    reader.onload = () => {
                    error.data = JSON.parse(reader.result);
                    resolve(Promise.reject(error));
                    };
                    reader.onerror = () => {
                    reject(error);
                    };
                    reader.readAsText(error.data);
                })
                .then(err => {
                    console.log(err.data)
                });
            }
            errormessage.then(success=>{
                console.log(success)
            }).catch(error=>{
                if(error.data.status=='error'){
                    this.errorStatus = true;
                }
            });
        },
    },
  };
</script>
