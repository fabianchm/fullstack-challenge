<script setup>
import { ref, onMounted } from 'vue'
import { FindPortfolioById } from '@/context/finance/portfolio/application/FindPortfolioById'
import { PortfolioApiRepository } from '@/context/finance/portfolio/infrastructure/PortfolioApiRepository'
import AllocationList from './AllocationList.vue'
import OrderList from '@/framework/components/order/OrderList.vue'

let data = ref(null)
let isLoaded = ref(false)

const orderListRef = ref()
const params = new URLSearchParams(window.location.search);
const portfolio = params.get('portfolio')

onMounted(() => {
    fetchData()
})

async function fetchData() {
    isLoaded.value = false
    data.value = await FindPortfolioById(PortfolioApiRepository(), portfolio)
    isLoaded.value = true
    if (data.value !== null) {
        fetchOrdersData()
        return
    }
}

function fetchOrdersData() {
    setTimeout(() => {
        orderListRef.value.fetch()
    }, 1)
}

function reload() {
    fetchData()
}
</script>

<template>
    <div v-if="isLoaded === true && data !== null" class="my-4 text-center">
        <h2>PORTFOLIO ID: {{data.Id}}</h2>
        <div class="flex md:flex-nowrap flex-wrap place-content-around mt-4">
            <AllocationList v-bind:allocations="data.allocations" />
            <OrderList ref="orderListRef" @updatePortfolio="reload" :portfolio="portfolio"/>
        </div>
    </div>
    <div class="my-4 h-5/6 w-auto flex justify-center items-center" v-else-if="isLoaded === false"> Loading... </div>
    <div v-else class="my-4 text-center"> There is no portfolio with this id</div>
</template>
