<template>
    <div class="w-full">
        <div class="w-100" v-for="(page, idx) in pages" src="" :key="'img-' + idx">
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
        }
    },
    created(){
        axios.get(route('api.pages.show', {
            comicId: this.$route.params.comicId,
            chapter: this.$route.params.chapter,
            page: this.$route.params.page
        }))
        .then((response) => {
            this.pages = response.data
        })
        .catch((error) => {

        })
    },
}
</script>

<style>

</style>