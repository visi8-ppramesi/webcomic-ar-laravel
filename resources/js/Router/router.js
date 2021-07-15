import VueRouter from "vue-router";
import Home from '../Pages/Home.vue'
import Comics from '../Pages/Comics.vue'
import ComicNew from '../Pages/ComicNew.vue'
import Login from '../Pages/Login.vue'
import Logout from '../Pages/Logout.vue'
import AppLayout from '../Layout/AppLayout.vue'
import store from '../Store/store'

const routes = [
    {
        path: '/',
        component: AppLayout,
        name: 'appLayout',
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: 'home',
                component: Home,
                name: 'home',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/comics',
                component: Comics,
                name: 'comics',
                meta: {
                    requiresAuth: true
                }
            },
            {
                path: '/comic/new',
                component: ComicNew,
                name: 'comicNew',
                meta: {
                    requiresAuth: true
                }
            },
        ]
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/logout',
        component: Logout,
        name: 'logout',
        meta: {
            requiresAuth: true,
        }
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem("token")
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.loggedIn && !loggedIn) {
            next({
                name: 'login',
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
        if (store.getters.loggedIn) {
            next({
                name: 'admin',
            })
        } else {
            next()
        }
    } else {
        next()
    }
});

export default router