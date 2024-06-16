<script setup>
import { ref } from 'vue'
import { Create } from '@/context/finance/order/application/Create'
import { OrderApiRepository } from '@/context/finance/order/infrastructure/OrderApiRepository'
import { formOrderParser } from '@/context/finance/order/domain/OrderParser'

const isOpen = ref(false)
const orderId = ref("")
const allocationId = ref("")
const shares = ref("")
const type = ref("buy")
const props = defineProps(['portfolioId'])
const emit = defineEmits(['updateView'])

function toggle() {
    isOpen.value = !isOpen.value
}

defineExpose({
    toggle,
})


function submit() {
    const order = {
        id: orderId.value,
        portfolio: parseInt(props.portfolioId),
        allocation: allocationId.value,
        shares: shares.value,
        type: type.value
    }

    Create(
        OrderApiRepository(), 
        formOrderParser(order)
    )

    clearForm()

    emit('updateView')

    toggle()
}

function clearForm() {
    orderId.value = ""
    allocationId.value = ""
    shares.value = ""
    type.value = "buy"
}
</script>

<template>
    <div v-if="isOpen === true">
        <div @click="toggle" class="absolute top-0 left-0 right-0 bottom-0 z-10 bg-black opacity-75 w-full h-full"></div>
        <div class="fixed top-1/2 left-1/2 md:w-6/12 w-full h-auto bg-white z-20 rounded-md -translate-y-1/2 -translate-x-1/2">
            <div class="md:px-16 px-8 py-8 flex flex-col">
                <h1 class="font-bold flex justify-start mb-8"> CREATE ORDER </h1>
                <div class="flex flex-col justify-items-start">
                    <div class="flex justify-start items-center my-2">
                        <label class="mr-4 w-32 text-left">Order ID: </label>
                        <input type="number" v-model="orderId" placeholder="Order ID" class="border-b border-b-primary p-1 w-full"/>
                    </div>

                    <div class="flex justify-start items-center my-2">
                        <label class="mr-4 w-32 text-left">Portfolio ID: </label>
                        <input type="number" :value="props.portfolioId" placeholder="Portfolio ID" class="border-b border-b-primary p-1 w-full" readonly/>
                    </div>

                    <div class="flex justify-start items-center my-2">
                        <label class="mr-4 w-32 text-left">Allocation ID: </label>
                        <input type="number" v-model="allocationId" placeholder="Allocation ID" class="border-b border-b-primary p-1 w-full"/>
                    </div>

                    <div class="flex justify-start items-center my-2">
                        <label class="mr-4 w-32 text-left">Shares: </label>
                        <input type="number" v-model="shares" placeholder="Shares" class="border-b border-b-primary p-1 w-full"/>
                    </div>

                    <div class="flex justify-start items-center my-2">
                        <label class="mr-4 w-32 text-left">Type: </label>
                        <select v-model="type" class="border-b border-b-primary p-1 w-full bg-white">
                            <option value="buy">Buy</option>
                            <option value="sell">Sell</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end mt-8">
                    <button type="button" @click="toggle" class="px-4 py-2 bg-white text-primary rounded border border-primary mx-4"> Cancel </button>
                    <button type="button" @click="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-secondary"> Create </button>
                </div>
            </div>
        </div>
    </div>
</template>

