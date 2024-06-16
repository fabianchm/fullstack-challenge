import {Order} from "./Order"
import type { OrderListType, OrderType } from "./OrderType"

export const orderParser = (data: OrderListType): Order[] => {
    return data.orders.map((order: OrderType) => {
        return new Order(order.id, order.portfolio, order.allocation, order.shares, order.type)
    })
}
