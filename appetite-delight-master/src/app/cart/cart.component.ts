import { Component, OnInit } from '@angular/core';
import { CartService } from '../utils/cart.service';
import { products } from '../data';

@Component({ selector: 'app-cart', templateUrl: './cart.component.html', styleUrls: ['./cart.component.css'] })

export class CartComponent implements OnInit {

  constructor(private cartService: CartService) {
  }

  products: products[];
  items: products[];


   totalCost: object = {
    total : 0,

    newVal : 9,

    addtotal() {
      this.total += this.newVal;
    }
   };

 addCart() {
   this.items = this.cartService.newProduct;
   console.log(typeof this.items);
   return this.items;

 }
 remove() {
   return this.cartService.remove();
 }
  ngOnInit() {this.addCart(); }
}
