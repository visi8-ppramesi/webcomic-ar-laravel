<template>
    <div class="pa-2 w-full">
        <div class="flex flex-col justify-end items-center bg-blue-100 w-150 h-40 pb-8 featured-block" style="background-image: linear-gradient(rgba(245, 246, 252, 0) 50%, rgb(49 46 129)), url(/storage/media/covers/kara.jpg);"> <!-- add featured comic here -->
            <div class="mb-6 text-white">
                <div class="text-center text-7xl">Kara</div>
                <div class="text-center text-2xl">Guardian of Realms</div>
                <div class="text-center text-base subsubtitle">Adventure, Teen, Magical</div>
            </div>
        </div>
        <div class="px-5 bg-gradient-to-t  to-indigo-900 from-green-400">
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
                    <div>{{$_.startCase($_.toLower(tag))}}</div>
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
                'dolor',
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
.subsubtitle{
    color: #41b3a9;
}
.featured-block{
    height: calc(100vh - 64px);
    background-size: cover;
    background-position: center;
}
</style>
