<script setup>
import { ref } from "vue"
import { FindUncompletedOrdersFromPortfolio } from '@/context/finance/order/application/FindUncompletedOrdersFromPortfolio'
import { OrderApiRepository } from '@/context/finance/order/infrastructure/OrderApiRepository'

let orders = ref(null)
let isLoaded = ref(false)

const props = defineProps(['portfolio'])

async function fetch() {
    isLoaded.value = false
    orders.value = await FindUncompletedOrdersFromPortfolio(OrderApiRepository(), props.portfolio)
    isLoaded.value = true
}

defineExpose({
    fetch,
})
</script>

<template>
    <div v-if="isLoaded === true" class="w-full p-4">
        <table class="border-colapse border w-full">
            <thead>
                <tr><th colspan="5" class="text-center border">ORDERS</th></tr>
            </thead>
            <tbody>
                <tr class="font-bold"> 
                    <td class="border">ID</td>
                    <td class="border">Allocation</td>
                    <td class="border">Shares</td>
                    <td class="border">Type</td>
                    <td class="border"></td>
                </tr>
                <tr v-for="order in orders">
                    <td class="border">{{order.Id}}</td>
                    <td class="border">{{order.Allocation}}</td>
                    <td class="border">{{order.Shares}}</td>
                    <td class="border">{{order.Type}}</td>
                    <td class="border">
                        <button type="button" class="px-4 py-2 my-1 bg-primary text-white rounded hover:bg-secondary">Complete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else> Loading...</div>
</template>
