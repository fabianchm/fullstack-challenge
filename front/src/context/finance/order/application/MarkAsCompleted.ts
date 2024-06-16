import { type OrderRepository } from '@/context/finance/order/domain/OrderRepository'

export const MarkAsCompleted = (orderRepository: OrderRepository, id: number) => {
  return orderRepository.markAsCompleted(id)
}
