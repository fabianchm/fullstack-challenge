import {Portfolio} from "./Portfolio"
import {Allocation} from "./Allocation"

export const portfolioParser = (data: any): Portfolio => {
    const allocations = data.allocations.map((allocationData: any) => {
        return new Allocation(allocationData.id, allocationData.shares)
    })

    return new Portfolio(data.id, allocations)
}
