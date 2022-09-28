import { Component, OnInit } from '@angular/core';
import { ShopService } from '../utils/shop.service';
import { products } from '../data';
import { Router } from '@angular/router';
import { CartService } from '../utils/cart.service';
import { AuthService } from '../utils/auth.service';
import { AngularFireAuth } from '@angular/fire/auth';
import * as firebase from 'firebase/app';
import { Observable } from 'rxjs';

@Component({ selector: 'app-shop', templateUrl: './shop.component.html', styleUrls: ['./shop.component.css'] })


export class ShopComponent implements OnInit {
user: Observable<firebase.User>;
  constructor(private authService: AuthService ,
              private shopService: ShopService ,
              public router: Router,
              private cartService: CartService,
              public firebaseAuth: AngularFireAuth) {

                firebaseAuth.auth.onAuthStateChanged(user => {
                  return user;
                });
                }

    products: products[];
    // user = null;


  onSelect(product: products ) {
    this.user = this.firebaseAuth.user;
    console.log( this.user);

    if (this.user != null) {
      console.log(product);
      this.cartService.addCart(product);
      this.router.navigate(['/cart']);

    } else {
      this.router.navigate(['/login']);
    }
  }
  getProducts(): void {
    this.products = this.shopService.getProducts();
  }

  ngOnInit() {
    this.getProducts();
  }

}
