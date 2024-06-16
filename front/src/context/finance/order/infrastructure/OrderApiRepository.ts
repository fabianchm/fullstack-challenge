import axios from "axios"
import { AxiosError } from "axios"
import { type OrderRepository } from "@/context/finance/order/domain/OrderRepository"
import { orderParser } from "@/context/finance/order/domain/OrderParser"
import type { Order } from "../domain/Order"

export const OrderApiRepository = (): OrderRepository => {
  return {
    findUncompletedByPortfolioId,
    markAsCompleted,
    create,
  }
}

async function findUncompletedByPortfolioId(id: number) {
    const url = import.meta.env.VITE_API_URL
    return await axios.get(`${url}/orders/${id}`)
        .then((response) => orderParser(response.data))
        .catch((error: AxiosError) => {
            throw new Error(error.message)
        })
}

async function markAsCompleted(id: number) {
    const url = import.meta.env.VITE_API_URL
    return await axios.patch(`${url}/orders/${id}`, {
            headers: {
                "Access-Control-Allow-Methods": "*"
            },
            status: "completed"
        })
        .catch((error: AxiosError) => {
            throw new Error(error.message)
        })
}

async function create(order: Order) {
    const url = import.meta.env.VITE_API_URL
    return await axios.post(`${url}/orders`, {
            id: order.Id,
            portfolio: order.Portfolio,
            allocation: order.Allocation,
            shares: order.Shares,
            type: order.Type
        }, {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .catch((error: AxiosError) => {
            throw new Error(error.message)
        })
}
