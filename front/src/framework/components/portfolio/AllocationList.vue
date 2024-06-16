<script setup>
    import { Allocation } from '@/context/finance/portfolio/domain/Allocation'

    defineProps({
        allocations: Array,
    })
</script>

<template>
    <div class="w-full p-4">
        <table class="border-colapse border w-full">
            <thead>
                <tr><th colspan="2" class="text-center border">ALLOCATIONS</th></tr>
            </thead>
            <tbody>
                <tr class="font-bold"> 
                    <td class="border">ID</td>
                    <td class="border">Shares</td>
                </tr>
                <tr v-for="allocation in allocations">
                    <td class="border">{{allocation.Id}}</td>
                    <td class="border">{{allocation.Shares}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
