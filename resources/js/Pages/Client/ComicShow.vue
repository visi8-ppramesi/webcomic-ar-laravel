<template>
    <div>
        <div class="description-block text-white flex flex-col justify-end p-5" :style="'background-image:linear-gradient(to bottom, rgba(245, 246, 252, 0), rgb(0 0 0 / 73%)), url(' + comic.cover_url + ');'"><!-- top block -->
            <div>
                <template v-for="(genre, idx) in genres">
                    <router-link :to="{name: 'search', query: {search: genre}}" :key="'genre-' + idx">{{genre}}<span v-if="idx < genres.length - 1" :key="'comma-' + idx">, </span></router-link> 
                </template>
            </div><!-- make it linkable later -->
            <div>{{comic.title}}</div>
            <div>
                <template v-for="(author, idx) in authors">
                    <router-link :to="{name: 'authorShow', params: {authorId: author.id}}" :key="'author-' + idx">{{author.name}}<span v-if="idx < authors.length - 1" :key="'comma-' + idx">, </span></router-link> 
                </template>
            </div>
            <div>{{comic.description}}</div>
            <div class="flex flex-row">
                <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">View with AR</button>
                 <template v-if="purchased">
                    <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" v-if="$_.isEmpty(bookmark)" @click="startReading">Start Reading</button>
                    <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" v-else @click="continueReading">Continue Reading</button>
                </template>
                <template v-else>
                    <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="purchaseComic">Buy Comic</button>
                </template>
                <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="favorite">Favorite</button>
            </div>
        </div>
        <div>
            <div class="flex flex-row h-20" v-for="(preview, idx) in previews" :key="'preview-'+idx" @click="goToChapter(preview.chapter)">
                <div class="flex-none">
                    <img class="h-20" :src="preview.image_url" alt="">
                </div>
                <div class="flex-grow flex flex-col p-3">
                    <div>Ep. {{preview.chapter}}</div>
                    <div class="flex flex-row w-100">
                        <div class="mr-2">[put heart here]</div>
                        <div>{{preview.release_date}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'comic-show',
    components: {},
    data(){
        return {
            comic: {},
            bookmark: {},
            purchased: false,
            authors: [],
            tags: [],
            previews: [],
            genres: []
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
        parseAuthors(){
            this.comic.authors.forEach(element => {
                this.authors.push({
                    name: element.name,
                    id: element.id
                })
            });
        },
        purchaseComic(){
            let cart = JSON.parse(localStorage.getItem('cart') || '[]')
            cart.push(this.$route.params.comicId)
            localStorage.setItem('cart', JSON.stringify(cart))
            this.$router.push({name: 'paymentShow'})
        },
        startReading(){
            this.$router.push({name: 'pageShow', params: {
                comicId: this.$route.params.comicId,
                chapter: 1,
            }})
        },
        continueReading(){
            this.$router.push({name: 'pageShow', params: {
                comicId: this.$route.params.comicId,
                chapter: this.bookmark.chapter
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