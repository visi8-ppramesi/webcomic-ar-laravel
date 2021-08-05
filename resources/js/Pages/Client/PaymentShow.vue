<template>
    <div>
        <div>
            <div v-for="(item, idx) in cartItems" :key="'cart-' + idx" class="mb-2">
                <div>
                    {{item.title}}
                </div>
                <input type="checkbox" v-model="arSelected[item.id]" :value="item.id"> Buy AR
            </div>
        </div>
        <div>Choose Method:</div>
        <div>
            <div>Credit/Debit Card</div>
            <form>
                <div class="grid grid-cols-5 gap-x-4 gap-y-1">
                    <label for="name" class="col-span-2 text-right text-sm">Card Holder Name</label>
                    <input type="text" class="col-span-3 bg-gray-300 appearance-none border-2 border-gray-300 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="name">
                    <label for="name" class="col-span-2 text-right text-sm">Card Number</label>
                    <input type="text" class="col-span-3 bg-gray-300 appearance-none border-2 border-gray-300 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="cardNumber">
                    <label for="name" class="col-span-2 text-right text-sm">Expiration Date</label>
                    <input type="text" class="col-span-3 bg-gray-300 appearance-none border-2 border-gray-300 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="expDate">
                    <label for="name" class="col-span-2 text-right text-sm">CCV Number</label>
                    <input type="text" class="col-span-3 bg-gray-300 appearance-none border-2 border-gray-300 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="ccv">
                </div>
            </form>
        </div>
        <div>
            <div>Online Payment</div>
            <div>[button] [button] [button] [button]</div><!-- add buttons for ovo gopay etc here -->
        </div>
        <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="submit">Submit</button>
    </div>
</template>

<script>
export default {
    name:'payment-page',
    created(){
        let cart = localStorage.getItem('cart')
        axios.get(route('api.comics.list', {where_in_id: cart}))
        .then((response) => {
            this.cartItems = response.data
        })
    },
    data(){
        return {
            cartItems: [],
            arSelected: {}
        }
    },
    methods:{
        submit(){
            let arBought = []
            Object.keys(this.arSelected).map((el) => {
                if(this.arSelected[el]){
                    arBought.push(el)
                }
            })
            axios.get(route('api.comics.purchase'), {
                comic_ids: JSON.stringify(this.cartItems.map((el) => el.id)),
                ar_bought: JSON.stringify(arBought)
            })
        }
    }
}
</script>

<style>

</style>