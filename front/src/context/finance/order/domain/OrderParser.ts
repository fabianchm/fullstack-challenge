import {Order} from "./Order"
import type { OrderListType, OrderType } from "./OrderType"

export const orderParser = (data: OrderListType): Order[] => {
    return data.orders.map((order: OrderType) => {
        return new Order(order.id, order.portfolio, order.allocation, order.shares, order.type)
    })
}

export const formOrderParser = (data: OrderType): Order => {
    return new Order(data.id, data.portfolio, data.allocation, data.shares, data.type)
}
