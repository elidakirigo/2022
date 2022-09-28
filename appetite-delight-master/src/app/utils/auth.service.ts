import { Injectable } from '@angular/core';
import { AngularFireAuth } from '@angular/fire/auth';
import { Observable } from 'rxjs';
import * as firebase from 'firebase/app';
import { Router } from '@angular/router';
import { CartService } from './cart.service';


@Injectable({
  providedIn: 'root'
})
export class AuthService {
  User: firebase.Unsubscribe;

  constructor(public firebaseAuth: AngularFireAuth,
              public carService: CartService,
              public route: Router) { this.user = firebaseAuth.authState; }
  user: Observable<firebase.User>;
  selectedClass: string;
  public message = {text: ''};
  public muserid: string;
  public database: any;
  public ref: any;
  public data: any;
  public newUser = null;

  public signup(email: string, password: string) {
    this.message = { text : 'validating...'};
    this.firebaseAuth
      .auth
      .createUserWithEmailAndPassword(email, password)
      .then(user => {
        this.message = { text : ''};
        this.route.navigate(['/shop']);
        console.log('Success!', user);
      })
      .catch(err => {
        this.message = { text : 'the server is experiencing some technical errors,please check on your connectivity'};
        console.log('Something went wrong:', err.message);
        this.route.navigate(['/login']);
      });
  }

  public login(email: string, password: string) {
    this.message = { text : 'validating...'};
    this.firebaseAuth
      .auth
      .signInWithEmailAndPassword(email, password)
      .then((user) => {
        if (user) {
          this.route.navigate(['/shop']); }
      })

      .catch(err => {
        this.message = { text : 'Invalid Email/Password.PLease try again'};
        this.route.navigate(['/login']);
      });
  }

  public logout() {
    this.firebaseAuth
      .auth
      .signOut();
    this.route.navigate(['/home']);
  }
  definEser() {

  this.User = this.firebaseAuth.auth.onAuthStateChanged(user => {
    console.log( user, 'uu' );

    return this.newUser = 1;
  });
  console.log(this.newUser, 'NEWNEWNEW', this.newUser, 'newewe' ) ;

  }
}

