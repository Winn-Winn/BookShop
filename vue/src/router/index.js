import { createRouter, createWebHistory } from 'vue-router'
import TestingData from '../pages/index.vue'

const routes = [
    {
        path: '/test',
        name: 'TestingData',
        component: TestingData
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;