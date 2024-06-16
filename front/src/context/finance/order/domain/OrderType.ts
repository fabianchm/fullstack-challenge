export type OrderType = {
    id: number,
    portfolio: number,
    allocation: number,
    shares: number,
    type: string
}

export type OrderListType = {
    orders: OrderType[]
}
