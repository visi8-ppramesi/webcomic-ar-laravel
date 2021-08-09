<template>
    <div class="w-full">
        <div class="w-full mt-1 mb-2 px-5 py-2">
            <label for="chapter">Select chapter</label>
            <div class="flex">
                <svg @click="prevChapter" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 mr-1" fill="none" viewBox="0 0 24 24" :stroke="prevEnabled ? '#2f2f2f' : '#919191'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <select class="form-select block w-full mt-1" @change="changeChapter(selectedChapter)" v-model="selectedChapter">
                    <option v-for="(chapter, idx) in chapters" :value="chapter" :key="'cpt-' + idx">{{chapter}}</option>
                </select>
                <svg @click="nextChapter" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 ml-1" fill="none" viewBox="0 0 24 24" :stroke="nextEnabled ? '#2f2f2f' : '#919191'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </div>
        <div class="w-100" v-for="(page, idx) in pages" :key="'img-' + idx">
            <img :src="page.image_url">
        </div>
    </div>
</template>

<script>
export default {
    name:'page',
    data(){
        return {
            pages: [],
            chapters: [],
            selectedChapter: this.$route.params.chapter,
            prevEnabled: false,
            nextEnabled: false
        }
    },
    methods:{
        changeChapter(newchapter){
            // this.fetchPages(this.$route.params.comicId, this.selectedChapter)
            this.$router.push({name: 'pageShow', params: {
                comicId: this.$route.params.comicId,
                chapter: newchapter
            }})
        },
        nextChapter(){
            if(this.nextEnabled){
                let currentChapter = this.chapters.length - (this.chapters.slice().reverse().findIndex((el) => el == this.$route.params.chapter)) - 1
                this.changeChapter(this.chapters[currentChapter + 1])
            }
        },
        prevChapter(){
            if(this.prevEnabled){
                let currentChapter = this.chapters.length - (this.chapters.slice().reverse().findIndex((el) => el == this.$route.params.chapter)) - 1
                this.changeChapter(this.chapters[currentChapter - 1])
            }
        },
        fetchChapters(comicId){
            return axios.get(route('api.comic.get.chapters', {comicId: comicId}))
            .then((response) => {
                this.chapters = response.data
            })
            .catch((error) => {

            })
        },
        fetchPages(comicId, chapter){
            return axios.get(route('api.pages.show', {
                comicId: comicId,
                chapter: chapter
            }))
            .then((response) => {
                this.pages = response.data
            })
            .catch((error) => {

            })

        }
    },
    created(){
        this.fetchChapters(this.$route.params.comicId)
        .then((resp) => {
            this.prevEnabled = this.$route.params.chapter != this.chapters[0]
            this.nextEnabled = this.$route.params.chapter != this.chapters[this.chapters.length - 1]
        })
        this.fetchPages(this.$route.params.comicId, this.$route.params.chapter)
    },
}
</script>

<style>

</style>