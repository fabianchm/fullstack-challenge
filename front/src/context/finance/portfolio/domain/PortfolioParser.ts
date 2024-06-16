import {Portfolio} from "./Portfolio"
import {Allocation} from "./Allocation"
import type { PortfolioType } from "./PortfolioType"

export const portfolioParser = (data: PortfolioType): Portfolio => {
    const allocations = data.allocations.map((allocationData: any) => {
        return new Allocation(allocationData.id, allocationData.shares)
    })

    return new Portfolio(data.id, allocations)
}
