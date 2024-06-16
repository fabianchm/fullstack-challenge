<script setup>
import { nextTick, ref, reactive, onMounted } from 'vue'
import { FindPortfolioById } from '@/context/finance/portfolio/application/FindPortfolioById'
import { PortfolioApiRepository } from '@/context/finance/portfolio/infrastructure/PortfolioApiRepository'

let data = ref(null)
let isLoaded = ref(false)
const params = (new URL(document.location)).searchParams;
const portfolio = params.get('portfolio')

onMounted(() => {
    fetchData()
})

async function fetchData() {
    isLoaded.value = false
    data.value = await FindPortfolioById(PortfolioApiRepository(), portfolio)
    isLoaded.value = true
}
</script>

<template>
    <div v-if="isLoaded === true" class="my-4 text-center">
        <h3>Portfolio ID: {{data.Id}}</h3>
        <table class="border-colapse border mt-4">
            <thead>
                <tr><th colspan="2" class="text-center border">ALLOCATIONS</th></tr>
            </thead>
            <tbody>
                <tr class="font-bold"> 
                    <td class="border">ID</td>
                    <td class="border">Shares</td>
                </tr>
                <tr v-for="allocation in data.allocations">
                    <td class="border">{{allocation.Id}}</td>
                    <td class="border">{{allocation.Shares}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="my-4 h-5/6 w-auto flex justify-center items-center" v-else> Loading... </div>
</template>
