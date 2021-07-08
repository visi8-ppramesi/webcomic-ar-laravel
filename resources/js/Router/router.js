import VueRouter from "vue-router";

const routes = [
    {
        path: '',
        component: import('../Pages/Home.vue'),
        name: 'home'
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router