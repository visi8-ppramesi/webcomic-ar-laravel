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
                            <button v-if="$_.isEmpty(bookmark)" @click="startReading">Start Reading</button>
                            <button v-else @click="continueReading">Continue Reading</button>
                        </template>
                        <template v-else>
                            <button @click="purchaseComic">Buy Comic</button>
                        </template>
                    </div>
                    <div><!-- favorite -->
                        <button @click="favorite">Favorite</button>
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
                    <div></div><!-- authors value -->
                </div>
            </div>
            <div><!-- genres -->
                <div>Genres:</div>
                <div>
                    <div></div><!-- genres value -->
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
            purchased: false
        }
    },
    created(){
        axios.get(route('api.comic.show', {comic: this.$route.params.comicId}))
        .then((response) => {
            this.comic = response.data
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
            // if(error.response.status = 401){
            //     this.$router.push({ name: 'login' })
            // }else{
            // }
        })
    },
    methods: {
        purchaseComic(){//for now this just automatically trigger purchase comic, later it will redirect to shopping cart page
            axios.get(route('api.comic.purchase', {comic: this.$route.params.comicId}))
            .then()
        },
        startReading(){

        },
        continueReading(){

        },
        favorite(){

        }
    }
}
</script>

<style>

</style>