export class Order {
    constructor(
        public orderNumber: number,
        public orderDate: Date,
        public requiredDate: Date,
        public shippedDate: Date,
        public status: string,
        public comments: string,
        public customerNumber: number,
        public productCode: string,
        public quantityOrdered: number,
        public priceEach: number
    ) {

    }
}