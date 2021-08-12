<template>
    <div>
        <div class="description-block text-white flex flex-col justify-end p-5" :style="'background-image:linear-gradient(to bottom, rgba(245, 246, 252, 0), rgb(0 0 0 / 73%)), url(' + comic.cover_url + ');'"><!-- top block -->
            <div>
                <template v-for="(genre, idx) in genres">
                    <router-link :to="{name: 'search', query: {search: genre}}" :key="'genre-' + idx">{{genre}}<span v-if="idx < genres.length - 1" :key="'comma-' + idx">, </span></router-link>
                </template>
            </div><!-- make it linkable later -->
            <div class="text-2xl font-bold">{{comic.title}}</div>
            <div>
                <template v-for="(author, idx) in authors">
                    <router-link :to="{name: 'authorShow', params: {authorId: author.id}}" :key="'author-' + idx">{{author.name}}<span v-if="idx < authors.length - 1" :key="'comma-' + idx">, </span></router-link>
                </template>
            </div>
            <div class="text-sm">{{comic.description}}</div>
            <div class="flex flex-row content-center justify-between">
                 <template v-if="purchased">
                    <button class="text-sm mt-3 mt-3 inline-flex items-center justify-center p-2 rounded-full text-gray-50 bg-green-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="continueReading(true)">View with AR</button>
                    <button class="text-sm mt-3 inline-flex items-center justify-center p-2 rounded-full text-gray-50 bg-green-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" v-if="$_.isEmpty(bookmark)" @click="startReading">Start Reading</button>
                    <button class="text-sm mt-3 inline-flex items-center justify-center p-2 rounded-full text-gray-50 bg-green-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" v-else @click="continueReading(false)">Continue Reading</button>
                </template>
                <!-- <template v-else>
                    <button class="mt-3 inline-flex items-center justify-center p-2 rounded-full text-gray-50 bg-green-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="openModal">Buy Comic</button>
                </template> -->
                <button class="mt-3 inline-flex items-center justify-center p-2 rounded-full text-gray-50 bg-green-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="favorite">Favorite</button>
            </div>
        </div>
        <div class="divide-y divide-black">
            <div class="flex flex-row h-20 bg-indigo-900 text-white" v-for="(preview, idx) in previews" :key="'preview-'+idx">
                <div class="flex-none w-1/5">
                    <img class="h-20" :src="preview.image_url" alt="">
                </div>
                <div class="flex-grow flex flex-col p-3 w-3/5" @click="goToChapter(preview.chapter)">
                    <div>Ep. {{preview.chapter}}</div>
                    <div class="flex flex-row w-100">
                        <div class="mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div class="text-xs">{{preview.release_date}}</div>
                    </div>
                </div>
                <div class="w-1/5 flex justify-center items-center" v-if="!$_.includes(purchaseObj.chapters, preview.chapter)">
                    <button class="text-xs items-center h-8 w-116  p-2 rounded-lg text-gray-50 bg-green-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="openModal(preview.chapter)">Buy Ep. {{preview.chapter}}</button>
                    <!-- <button @click="openModal(preview.chapter)">Buy Episode</button> -->
                </div>
            </div>
        </div>
        <modal v-model="modal">
            <template v-slot:body>
                <div class="p-6 flex flex-col content-center justify-center">
                    <img :src="comic.cover_url" class="h-1/2 rounded-lg">
                    <div>Rp. {{(comic.price).toLocaleString('id-ID')}}</div>
                    <div>Apakah kamu mau membeli Ep. {{episodeModal}}?</div>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex h-16 bg-purple-600 bg-opacity-25">
                    <button @click="modal = false" class="h-100 w-1/3">Cancel</button>
                    <button @click="addToCart" class="h-100 w-1/3">Add to Cart</button>
                    <button @click="purchaseComic" class="h-100 w-1/3">Purchase</button>
                </div>
            </template>
        </modal>
    </div>
</template>

<script>
import Modal from '../../Components/Modal.vue'

export default {
    name: 'comic-show',
    components: {
        Modal
    },
    data(){
        return {
            modal: false,
            comic: {},
            bookmark: {},
            purchased: false,
            purchaseObj: {},
            authors: [],
            tags: [],
            previews: [],
            genres: [],
            episodeModal: null
        }
    },
    created(){
        axios.get(route('api.comic.get.previews', {comicId: this.$route.params.comicId}))
        .then((response) => {
            this.previews = response.data
        })
        axios.get(route('api.comic.show', {comic: this.$route.params.comicId}))
        .then((response) => {
            this.comic = response.data
            this.tags = JSON.parse(this.comic.tags)
            this.genres = JSON.parse(this.comic.genres)
            this.parseAuthors()
            return axios.get(route('api.comic.check.purchased', {comicId: this.$route.params.comicId}))
        })
        .then((response) => {
            this.purchaseObj = response.data
            this.purchased = Object.keys({...response.data}).length > 0
            return axios.get(route('api.comic.check.bookmark', {comicId: this.$route.params.comicId}))
        })
        .then((response) => {
            this.bookmark = {...response.data}
        })
        .catch((error) => {
            this.$router.push({ name: 'notFound' })
        })
    },
    methods: {
        addToCart(){
            let cart = JSON.parse(localStorage.getItem('cart') || '{}')
            if(this.$route.params.comicId in cart){
                cart[this.$route.params.comicId].push(this.episodeModal)
            }else{
                cart[this.$route.params.comicId] = [this.episodeModal]
            }
            cart[this.$route.params.comicId] = this.$_.uniq(cart[this.$route.params.comicId])
            localStorage.setItem('cart', JSON.stringify(cart))
            this.episodeModal = null
            this.modal = false
        },
        parseAuthors(){
            this.comic.authors.forEach(element => {
                this.authors.push({
                    name: element.name,
                    id: element.id
                })
            });
        },
        openModal(chapter){
            this.episodeModal = chapter
            this.modal = true
        },
        purchaseComic(){
            // let cart = JSON.parse(localStorage.getItem('cart') || '[]')
            // cart.push(this.$route.params.comicId)
            // localStorage.setItem('cart', JSON.stringify(cart))
            this.addToCart()
            this.$router.push({name: 'paymentShow'})
        },
        startReading(){
            this.$router.push({name: 'pageShow', params: {
                comicId: this.$route.params.comicId,
                chapter: 1,
            }})
        },
        continueReading(ar = false){
            let chapter = this.bookmark.chapter || 1
            this.$router.push({name: 'pageShow', params: {
                comicId: this.$route.params.comicId,
                chapter: chapter
            },
            query:{
                ar: ar
            }})
        },
        gotToTag(){

        },
        favorite(){

        },
        goToChapter(chapter){
            this.$router.push({name: 'pageShow', params: {
                comicId: this.$route.params.comicId,
                chapter: chapter,
            }})
        }
    }
}
</script>

<style>
.description-block{
    height: calc(100vh - 64px);
    background-size: cover;
    background-position: center;
}
</style>
