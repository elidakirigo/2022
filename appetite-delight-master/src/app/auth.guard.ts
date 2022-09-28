import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, RouterStateSnapshot, CanActivate, Router } from '@angular/router';
import * as firebase from 'firebase/app';
import { AuthService } from './utils/auth.service';
import { AngularFireAuth } from '@angular/fire/auth';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements  CanActivate {


  constructor(private router: Router,
              private authService: AuthService,
              public firebaseAuth: AngularFireAuth) {
              }
  canActivate(
    next: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
  this.firebaseAuth.auth.onAuthStateChanged(user => {


      if (user != null) {
          return true;
      }
      this.router.navigate(['/login']);
      return false;
            });
  return true;
  }
}
