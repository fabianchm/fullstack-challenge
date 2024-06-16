export class Order
{
    constructor(
        public Id: number,
        public Portfolio: number,
        public Allocation: number,
        public Shares: number,
        public Type: string,
    ) {}

    get id()
    {
        return this.Id
    }

    get portfolio()
    {
        return this.Portfolio
    }

    get allocation()
    {
        return this.Allocation
    }

    get shares()
    {
        return this.Shares
    }

    get type()
    {
        return this.Type
    }

    set id(Id: number)
    {
        this.Id = Id
    }

    set portfolio(Portfolio: number)
    {
        this.Portfolio = Portfolio
    }

    set allocation(Allocation: number)
    {
        this.Allocation = Allocation
    }
    
    set shares(Shares: number)
    {
        this.Shares = Shares
    }

    set type(Type: string)
    {
        this.Type = Type 
    }
}
