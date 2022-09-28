import { Injectable } from '@angular/core';
import { products , Products } from '../data';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class ShopService {

  constructor(public router: Router) { }

  products = Products;
  newItem: products[];

 getProducts(): products[] {
   return Products;
 }
}
