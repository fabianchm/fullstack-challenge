import { Order } from './Order'

export interface OrderRepository {
  findUncompletedByPortfolioId: (id: number) => Promise<Order[]>

  markAsCompleted: (id: number) => void

  create: (order: Order) => void
}
