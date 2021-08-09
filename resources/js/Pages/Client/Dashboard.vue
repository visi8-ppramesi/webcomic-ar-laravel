<template>
    <div class="pa-2 w-full">
        <div class="bg-blue-100 w-150 h-40 mb-8"> <!-- add featured comic here -->
            featured comics
        </div>
        <div class="px-5">
            <div class="mb-3 text-white">
                <div>
                    <div class="text-white float-right">More</div>
                    <div>New Releases</div>
                </div>
                <div>
                    <horizontal-slider
                        :items="processToHorizontalSlider(comics.all.comics)"
                        :config="config"
                        objectCategory="all"
                        @nextPage="nextPage"
                    ></horizontal-slider>
                </div>
            </div>
            <div class="mb-3 text-white" v-for="(tag, idx) in shownTags" :key="'tag-' + idx">
                <div>
                    <div class="text-white float-right">More</div>
                    <div>Most Viewed</div>
                </div>
                <div>
                    <horizontal-slider
                        :items="processToHorizontalSlider(comics[tag].comics)"
                        :config="config"
                        :objectCategory="tag"
                        @nextPage="nextPage"
                    ></horizontal-slider>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HorizontalSlider from '../../Components/HorizontalSlider.vue'
export default {
    name: 'dashboard',
    components: {
        HorizontalSlider
    },
    created(){
        this.shownTags.forEach((elem) => {
            this.comics[elem] = {}
            this.comics[elem].comics = []
            this.getComics(route('api.comics.list', {...this.query, where_tag: elem}), elem)
        })
        this.getComics(route('api.comics.list', this.query), 'all')
    },
    data(){
        return {
            shownTags: [
                'asdf',
                'lorem'
            ],
            comics: {
                all: {
                    comics: []
                }
            },
            query: {
                paginate: 5,
                page: 1
            },
            config: {
                image: 'cover_url',
                title: 'title'
            }
        }
    },
    methods:{
        processToHorizontalSlider(comicObjects){
            let retVal = []
            comicObjects.forEach(element => {
                retVal.push({
                    url: '/comic/' + element.id,
                    cover_url: element.cover_url,
                    title: element.title
                })
            });
            return retVal
        },
        getComics(url, category){
            axios.get(url)
            .then((response) => {
                if(!this.comics[category]){
                    this.comics[category] = {}
                    this.comics[category].comics = response.data.data
                }else{
                    this.comics[category].comics = this.comics[category].comics.concat(response.data.data)
                }
                this.comics[category].paginationData = response.data
                this.comics[category].prevDisabled = this.comics[category].paginationData.prev_page_url === null
                this.comics[category].nextDisabled = this.comics[category].paginationData.next_page_url === null
                this.comics[category].prevPageUrl = this.comics[category].paginationData.prev_page_url
                this.comics[category].nextPageUrl = this.comics[category].paginationData.next_page_url
            })
            .catch((error) => {
                //do error catching later
            })
        },
        nextPage(category){
            if(!this.comics[category].nextDisabled){
                this.getComics(this.comics[category].nextPageUrl, category)
            }
        },
        prevPage(category){

        }
    }
}
</script>

<style>

</style>