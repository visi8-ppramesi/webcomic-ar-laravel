<template>
    <div>
        <div v-for="(comic, idx) in comics" :key="'comic-' + idx" class="bg-white w-1/2 space-y-3 px-6 py-4 mb-2 shadow-lg border flex flex-col">
            <div>
                <div>Title:</div>
                <div>{{comic.title}}</div>
            </div>
            <div>
                <div>Description:</div>
                <div>{{comic.description}}</div>
            </div>
            <div>
                <div>Cover:</div>
                <div><img :src="comic.cover_url"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'comics',
    data(){
        return {
            comics: []
        }
    },
    created(){
        axios.get(route('api.comics.list'))
        .then((response) => {
            this.comics = response.data
        })
    }
}
</script>

<style scoped>

</style>