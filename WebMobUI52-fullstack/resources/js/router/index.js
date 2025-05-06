import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/Home.vue'
import Stories from '@/views/Stories.vue'
import Chapter from '@/views/Chapter.vue'
import Ending from '@/views/Ending.vue'

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
    },
    {
        path: '/story/:storyId',
        name: 'story',
        component: Chapter
    },
    {
        path: '/story/:storyId/chapter/:chapterId',
        name: 'chapter',
        component: Chapter
    },
    {
        path: '/story/:storyId/ending/:persona',
        name: 'ending',
        component: Ending,
        props: true
    }

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
