<template>
    <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-10" v-if="value">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-xl shadow-lg z-50 overflow-y-auto">
            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <slot name="title"></slot>
                </div>

                <!--Body-->
                <slot name="body"></slot>
                <!--Footer-->
                <div class="flex justify-end pt-2">
                    <slot name="footer"></slot>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'modal',
    props: ['value'],
    created(){

    },
    methods: {

    }
}
</script>

<style scoped>

</style>