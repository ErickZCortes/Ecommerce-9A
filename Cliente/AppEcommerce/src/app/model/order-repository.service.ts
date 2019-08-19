import { Injectable } from '@angular/core';
import { Order } from './order';
import { OrderDatasourceService } from './order-datasource.service';

@Injectable({
    providedIn: 'root'
})
export class OrderRepositoryService {

    private order: Order[] = [];
    private orderNumber: string[] = [];

    constructor(private dataSourceService: OrderDatasourceService) {
        dataSourceService.getOrders().subscribe((response) => {
            this.order = response['orders'];
            this.orderNumber = response['orders'].map(o => o.orderNumber).filter((c, index, array) => array.indexOf(c) === index).sort();
        });
    }

    getOrders(): Order[] {
        return this.order;
    }

}