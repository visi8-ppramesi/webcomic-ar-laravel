import axios from "axios";
import Vue from "vue";
import Vuex from 'vuex';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        user: null,
        token: localStorage.getItem('token') || null,
    },
    mutations: {
        setToken (state, data) {
            localStorage.setItem('token', data.token)
            axios.defaults.headers.common.Authorization = `Bearer ${data.token}`
        },
        clearUserData () {
            localStorage.removeItem('token')
        },
        retrieveToken(state, token){
            state.token = token
        },
        destroyToken(state){
            state.token = null
        },
    },
    actions: {
        login({ commit }, credentials) {
            return axios.post(route('api.login'), credentials)
            .then(({ data }) => {
                commit('setToken', data)
            })
        },
        logout({ commit }) {
            commit('clearUserData')
            return axios.get(route('api.logout'))
        }
    },
    getters : {
        loggedIn(state){
            return state.token !== null
        },
    }
})

export default store