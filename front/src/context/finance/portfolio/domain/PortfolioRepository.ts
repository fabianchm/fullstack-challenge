import { Portfolio } from './Portfolio'

export interface PortfolioRepository {
  findById: (id: number) => Promise<Portfolio>
}
