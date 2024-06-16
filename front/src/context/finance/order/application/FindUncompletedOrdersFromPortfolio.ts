import { type OrderRepository } from '@/context/finance/order/domain/OrderRepository'

export const FindUncompletedOrdersFromPortfolio = (orderRepository: OrderRepository, id: number) => {
  return orderRepository.findUncompletedByPortfolioId(id)
}
