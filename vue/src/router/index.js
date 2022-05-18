import { createRouter, createWebHistory } from 'vue-router'
import LoginData from '../pages/login.vue'
import UserCreate from '../pages/user/create.vue'
import BookList from '../pages/books/list.vue'
import BookCreate from '../pages/books/create.vue'
import BookDetail from '../pages/books/detail.vue'
import CartList from '../pages/cart/list.vue'
import OrderList from '../pages/order/order_list.vue'

const routes = [
    {
        path: '/login',
        name: 'LoginData',
        component: LoginData
    },
    {
        path: '/register',
        name: 'UserCreate',
        component: UserCreate
    },
    {
        path: '/',
        name: 'BookList',
        component: BookList
    },
    {
        path: '/book/create/',
        name: 'BookCreate',
        component: BookCreate
    },
    {
        path: '/book/update/:id',
        name: 'BookUpdate',
        component: BookCreate
    },
    {
        path: '/book/detail/:id',
        name: 'BookDetail',
        component: BookDetail
    },
    {
        path: '/cart',
        name: 'CartList',
        component: CartList
    },
    {
        path: '/cart/:user_id',
        name: 'CartList',
        component: CartList
    },
    {
        path: '/order',
        name: 'OrderList',
        component: OrderList
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;