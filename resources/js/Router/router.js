import VueRouter from "vue-router";
import Home from '../Pages/Home.vue'
import Comics from '../Pages/Comics.vue'

const routes = [
    {
        path: '/comics',
        component: Comics,
        name: 'comics'
    },
    {
        path: '',
        component: Home,
        name: 'home'
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router