export class Allocation {
    constructor(
        public Id: number,
        public Shares: number
    ) {}

    get id() {
        return this.Id
    }

    get shares() {
        return this.Shares
    }
    
    set id(Id: number) {
        this.Id = Id
    }

    set shares(Shares: number) {
        this.Shares = Shares
    }
}

