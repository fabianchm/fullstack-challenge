<script setup>
import { ref } from "vue"
import { FindUncompletedOrdersFromPortfolio } from '@/context/finance/order/application/FindUncompletedOrdersFromPortfolio'
import { MarkAsCompleted } from '@/context/finance/order/application/MarkAsCompleted'
import { OrderApiRepository } from '@/context/finance/order/infrastructure/OrderApiRepository'
import CreateOrderForm from './CreateOrderForm.vue'

let orders = ref(null)
let isLoaded = ref(false)

const formRef = ref()
const props = defineProps(['portfolio'])
const emit = defineEmits(['updatePortolio'])

async function fetch() {
    isLoaded.value = false
    orders.value = await FindUncompletedOrdersFromPortfolio(OrderApiRepository(), props.portfolio)
    isLoaded.value = true
}

async function markAsCompleted(id) {
    await MarkAsCompleted(OrderApiRepository(), id)
    updatePortfolio()
}

function updatePortfolio() {
    emit('updatePortfolio')
}

defineExpose({
    fetch,
})

function toggleForm() {
    formRef.value.toggle()
}
</script>

<template>
    <div v-if="isLoaded === true" class="w-full p-4">
        <table class="border-colapse border w-full">
            <thead>
                <tr><th colspan="5" class="text-center border">ORDERS</th></tr>
            </thead>
            <tbody v-if="orders.length > 0">
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
                        <button type="button" @click="markAsCompleted(order.Id)" class="px-4 py-2 my-1 bg-primary text-white rounded hover:bg-secondary">Complete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="orders.length === 0"> This portfolio does not have any uncompleted order </div>
    </div>
    <div v-else> Loading...</div>

    <button type="button" @click="toggleForm" class="px-4 py-2 fixed bottom-10 right-10 bg-primary text-white rounded hover:bg-secondary"> Create order </button>

    <CreateOrderForm ref="formRef" @updateView="updatePortfolio" :portfolioId="portfolio"/>
</template>
