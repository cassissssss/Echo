import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/Home.vue'
import Stories from '@/views/Stories.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/stories',
        name: 'stories',
        component: Stories
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
