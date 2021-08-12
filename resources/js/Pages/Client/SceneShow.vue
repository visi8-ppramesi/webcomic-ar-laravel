<template>

</template>

<script>
export default {
    name: 'scene-show',
    data(){
        return {
            origHtmlClass: '',
        }
    },
    created(){
        axios.get(route('api.page.show.scene', {page: this.$route.params.pageId}))
        .then((response) => {
            const html = document.getElementsByTagName('html')[0]
            this.origHtmlClass = html.className
            document.body.insertAdjacentHTML('beforeend', response.data.scene)
        })
    },
    beforeDestroy(){
        const ascene = document.getElementsByTagName('a-scene')[0]
        ascene.parentNode.removeChild(ascene)
        const html = document.getElementsByTagName('html')[0]
        html.className = this.origHtmlClass
    },
}
</script>

<style scoped>

</style>
