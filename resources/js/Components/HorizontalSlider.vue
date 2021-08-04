<template>
    <div class="scrolling-wrapper">
        <div v-for="(item, idx) in items" class="card scroller-container mr-1" :key="'item-' + idx">
            <div>
                <router-link :to="item.url">
                    <img :src="item[config.image]" class="image">
                </router-link>
            </div>
            <div>
                {{item[config.title]}}
            </div>
        </div>
        <div @click="loadMore">load more</div>
    </div>
</template>

<script>
export default {
    name: 'horizontal-slider',
    props: {
        items: {
            type: Array,
            default: () => []
        },
        config: {
            type: Object,
            default: () => {}
        },
        objectCategory: {
            type: String,
            default: ''
        }
    },
    data(){
        return {
        }
    },
    methods:{
        loadMore(){
            this.$emit('nextPage', this.objectCategory)
        }
    }
}
</script>

<style>
.scrolling-wrapper{
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.scrolling-wrapper.card{
    flex: 0 0 auto;
}
.scrolling-wrapper::-webkit-scrollbar {
    display: none;
}
.scroller-container{
    max-height: 200px;
    min-width: 150px;
}
</style>