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
    getTestingData() {
        return new Promise((resolve, reject) => {
        axios.get('/test')
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error);
            })
        });
    }
}