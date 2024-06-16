import { type PortfolioRepository } from '@/context/finance/portfolio/domain/PortfolioRepository'

export const FindPortfolioById = (portfolioRepository: PortfolioRepository, id: number) => {
  return portfolioRepository.findById(id)
}
