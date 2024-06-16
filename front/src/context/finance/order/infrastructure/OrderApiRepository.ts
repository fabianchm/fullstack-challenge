import axios from "axios"
import { AxiosError } from "axios"
import { type OrderRepository } from "@/context/finance/order/domain/OrderRepository"
import { orderParser } from "@/context/finance/order/domain/OrderParser"

export const OrderApiRepository = (): OrderRepository => {
  return {
    findUncompletedByPortfolioId,
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
