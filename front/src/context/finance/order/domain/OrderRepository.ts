import { Order } from './Order'

export interface OrderRepository {
  findUncompletedByPortfolioId: (id: number) => Promise<Order[]>
}
