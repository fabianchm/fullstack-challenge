import { type OrderRepository } from '@/context/finance/order/domain/OrderRepository'
import type { Order } from '../domain/Order'

export const Create = (orderRepository: OrderRepository, order: Order) => {
  return orderRepository.create(order)
}
