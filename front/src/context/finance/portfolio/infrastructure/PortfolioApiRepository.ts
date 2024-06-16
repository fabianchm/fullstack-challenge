import axios from "axios"
import { AxiosError } from "axios"
import { type PortfolioRepository } from "@/context/finance/portfolio/domain/PortfolioRepository"
import { portfolioParser } from "@/context/finance/portfolio/domain/PortfolioParser"

export const PortfolioApiRepository = (): PortfolioRepository => {
  return {
    findById,
  }
}

async function findById(id: number) {
    const p = import.meta.env.VITE_API_URL
    return await axios.get(`${p}/portfolios/${id}`)
        .then((response) => portfolioParser(response.data))
        .catch((error: AxiosError) => {
            throw new Error(error.message)
        })
}
