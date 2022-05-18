import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('AUTH_TOKEN');

axios.interceptors.response.use((response) => {
    return response
  }, function (error) {
    let originalRequest = error.config
    if (error.response.status === 401 && !originalRequest._retry) {      
      localStorage.setItem('AUTH_TOKEN', '');
    }
    return Promise.reject(error)
  })

export class APIService {

  constructor() {}

    setAuthData(auth_data){
        localStorage.setItem('AUTH_TOKEN', auth_data.token);
        localStorage.setItem('USER_NAME', auth_data.user_name);
        localStorage.setItem('USER_ID', auth_data.user_id);
        localStorage.setItem('ROLE', auth_data.role);
    }

    getAuthData() {
        var auth_data = {
            token: localStorage.getItem('AUTH_TOKEN'),
            user_name: localStorage.getItem('USER_NAME'),
            user_id: localStorage.getItem('USER_ID'),
            role: localStorage.getItem('ROLE'),
        }
        return auth_data;
      }

    loginUser(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/login', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error);
            });
        });
    }

    createUser(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/register', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    getUsers() {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.get('/user/list', )
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    createBook(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/book/create', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    getBooks(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/book/list', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    deleteBook(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/book/delete', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    fileUpload(request_data) {
        return new Promise((resolve, reject) => {
          const token = localStorage.getItem('AUTH_TOKEN');
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
          axios.post('/book/upload',request_data)
              .then(response => {
                  resolve(response.data);
              })
              .catch(error => {
                  reject(error.response.data);
              });
        });
    }

    fileDownload() {
        return new Promise((resolve, reject) => {
        const token = localStorage.getItem('AUTH_TOKEN');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        axios.get('/book/download', {responseType:'blob'})
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response);
            });
        });
    }

    getDetailData(id) {
        return new Promise((resolve, reject) => {
        const token = localStorage.getItem('AUTH_TOKEN');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        axios.get(`/book/detail/${id}`)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response);
            });
        });
    }

    getBookData(id) {
        return new Promise((resolve, reject) => {
        const token = localStorage.getItem('AUTH_TOKEN');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        axios.get(`/book/update/${id}`)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response);
            });
        });
    }

    getCartList(user_id) {
        return new Promise((resolve, reject) => {
        const token = localStorage.getItem('AUTH_TOKEN');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        axios.post(`/cart/${user_id}`)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response);
            });
        });
    }

    addToCart(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/cart/add', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    updateCart(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/cart/update', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    removeCart(id) {
        return new Promise((resolve, reject) => {
        const token = localStorage.getItem('AUTH_TOKEN');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        axios.post(`/cart/remove/${id}`)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response);
            });
        });
    }

    clearAllCart(request_data) {
        return new Promise((resolve, reject) => {
        const token = localStorage.getItem('AUTH_TOKEN');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        axios.post('/clear', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response);
            });
        });
    }

    getCartDataByBook(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/cart', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    getComments(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/comment/list', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    addComment(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/comment/create', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    checkout(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/checkout', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    getOrderList(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/order/list', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }

    Order(request_data) {
        return new Promise((resolve, reject) => {
            const token = localStorage.getItem('AUTH_TOKEN');
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            axios.post('/order', request_data)
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error.response.data);
            });
        });
    }
}
