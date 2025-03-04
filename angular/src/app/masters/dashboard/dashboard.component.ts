import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../api.service';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-dashboard',
  imports: [RouterLink],
  templateUrl: './dashboard.component.html',
  styles: `
    .link-tag-dash{
      text-decoration:none
    }
  `
})



export class DashboardComponent implements OnInit {


  constructor(private api: ApiService) { }


  user_count = '';
  client_count = '';
  item_count = '';
  total_invoice_amount = '';
  menuData:any;

  ngOnInit(): void {

    this.api.tableApi('Dashboard_controller', 'user_master_total_users', '').subscribe((res: any) => {

      if (res.user) {
        this.user_count = res.user;
      } else {
        this.user_count = 'XXXX';
      }

    })

    this.api.tableApi('Dashboard_controller', 'client_master_total_clients', '').subscribe((res: any) => {

      if (res.client) {
        this.client_count = res.client;
      } else {
        this.client_count = 'XXXX';
      }

    })

    this.api.tableApi('Dashboard_controller', 'item_master_total_items', '').subscribe((res: any) => {

      if (res.item) {
        this.item_count = res.item;
      } else {
        this.item_count = 'XXXX';
      }

    })

    this.api.tableApi('Dashboard_controller', 'invoice_master_total_sales', '').subscribe((res: any) => {

      if (res.invoice_total_amount) {
        this.total_invoice_amount = '₹ ' + res.invoice_total_amount;
      } else {
        this.total_invoice_amount = 'XXXX';
      }

    })

    this.menuData = localStorage.getItem('menu');

    this.menuData = JSON.parse(this.menuData); 

  }





}
