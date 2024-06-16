import { Allocation } from './Allocation'

export class Portfolio
{
    constructor(
        public Id: number,
        public Allocations: Allocation[]
    ) {}

    get id()
    {
        return this.Id
    }

    get allocations()
    {
        return this.Allocations
    }

    set id(Id: number)
    {
        this.Id = Id
    }

    set allocations(Allocations: Allocation[])
    {
        this.Allocations = Allocations
    }
}
