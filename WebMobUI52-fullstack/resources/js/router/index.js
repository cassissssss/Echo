import { createRouter, createWebHistory } from 'vue-router'
import Stories from '@/views/Stories.vue'

const routes = [
    {
        path: '/',
        name: 'stories',
        component: Stories
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
