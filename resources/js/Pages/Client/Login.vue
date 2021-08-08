<template>
    <div class="bg-cover bg-no-repeat bg-center" style=" background-image: url(/storage/icon/cvr.jpg)">
        <div class="flex justify-center h-screen">
            <div class="w-full p-5 m-auto">
                <div class="mb-4">
                    <input class="shadow appearance-none border rounded-full w-full py-2 px-3 text-grey-darker" v-model="email" id="email" type="text" placeholder="Username">
                </div>
                <div class="pass-form">
                    <input class="shadow appearance-none border border-red rounded-full w-full py-2 px-3 text-grey-darker mb-3" v-model="password" id="password" type="password" placeholder="******************">
                </div>
                <div class="text-sm text-center text-white mb-10">
                    <router-link to="#">Forgot Password?</router-link>
                </div>
                <div v-if="loginFailed" class="text-red">Wrong password or email</div>
                <div class="flex items-center justify-between">
                    <button @click="login" class="bg-green-400 w-full hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-full" type="button">
                        LOG IN
                    </button>
                </div>
                <div class="text-m text-center mt-6 text-white">
                    <p>Dont Have Account Yet? <router-link to="#">Sign Up</router-link></p>
                </div>
                <div class="flex w-3">
                    <div class="w-5"></div>
                    <img class="ml-24 mt-5" :src="facebookIcon.default" />
                    <img class="ml-5 mt-5" :src="instagramIcon.default" />
                    <img class="ml-5 mt-5" :src="twitterIcon.default" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'login',
    data(){
        return {
            email: '',
            password: '',
            loginFailed: false,
            facebookIcon: require('../../../icons/facebook.png'),
            instagramIcon: require('../../../icons/instagram.png'),
            twitterIcon: require('../../../icons/twitter.png'),
        }
    },
    methods:{
        login(){
            this.$store.dispatch('login', {
                email: this.email,
                password: this.password,
            })
            .then(response => {
                this.$router.push({ name: 'dashboard' })
            })
            .catch(error => {
                this.loginFailed = true
            })
        },
    }
}
</script>