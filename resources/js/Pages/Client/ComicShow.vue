<template>
    <div>
        <div class="flex flex-row"><!-- top block -->
            <div class="w-40"><!-- cover image -->
                <img :src="comic.cover_url">
            </div>
            <div><!-- title block -->
                <div><!-- title -->
                    {{comic.title}}
                </div>
                <div><!-- subtitle -->

                </div>
                <div><!-- price -->
                    {{comic.price}}
                </div>
                <div><!-- buttons -->
                    <div><!-- buy/continue reading -->
                        <template v-if="purchased">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" v-if="$_.isEmpty(bookmark)" @click="startReading">Start Reading</button>
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" v-else @click="continueReading">Continue Reading</button>
                        </template>
                        <template v-else>
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="purchaseComic">Buy Comic</button>
                        </template>
                    </div>
                    <div><!-- favorite -->
                        <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="favorite">Favorite</button>
                    </div>
                </div>
            </div>
        </div>
        <div><!-- description block -->
            <div>Description</div><!-- description title -->
            <div>{{comic.description}}</div><!-- description text -->
        </div>
        <div><!-- about block -->
            <div>About Block:</div><!-- about title -->
            <div><!-- release date -->
                <div>Release Date:</div>
                <div>{{comic.release_date}}</div><!-- release date value -->
            </div>
            <div><!-- total pages -->
                <div>Total Pages:</div>
                <div></div><!-- total pages value -->
            </div>
            <div><!-- authors -->
                <div>Authors:</div>
                <div>
                    <div v-for="(author, idx) in authors" :key="'author-' + idx">
                        <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="$router.push({name: 'authorShow', params: {authorId: author.id}})">{{author.name}}</button>
                    </div><!-- authors value -->
                </div>
            </div>
            <div><!-- genres -->
                <div>Tags:</div>
                <div>
                    <div v-for="(tag, idx) in tags" :key="'tag-' + idx">
                        <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="gotToTag(tag)">{{tag}}</button>
                    </div><!-- genres value -->
                </div>
            </div>
        </div>
        <div><!-- page preview title block -->

        </div>
        <div><!-- pages block -->

        </div>
        <div><!-- recommendation block title -->

        </div>
        <div><!-- recommendation content block -->

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
        }
    },
    created(){
        axios.get(route('api.comic.show', {comic: this.$route.params.comicId}))
        .then((response) => {
            this.comic = response.data
            this.tags = JSON.parse(this.comic.tags)
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
                page: 1,
            }})
        },
        continueReading(){
            this.$router.push({name: 'pageShow', params: {
                comicId: this.$route.params.comicId,
                chapter: this.bookmark.chapter,
                page: this.bookmark.page_number,
            }})
        },
        gotToTag(){

        },
        favorite(){

        }
    }
}
</script>

<style>

</style>