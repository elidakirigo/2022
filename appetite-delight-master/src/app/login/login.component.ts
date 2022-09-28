import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../utils/auth.service';
import { AngularFireAuth } from '@angular/fire/auth';
import { LocalStorageService } from '../utils/local-storage.service';

const newLocal = 'local';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  emailPattern = '^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$';

  public email: string;

  public password: string;

  public message = {text: ''};

  constructor(public route: Router,
              public authService: AuthService, private af: AngularFireAuth,
              private localstorage: LocalStorageService) { }
  changeOne() {
    document.getElementsByClassName('container')[0].classList.add('x');
    document.getElementsByClassName('container')[1].classList.remove('x');
  }
  changeTwo() {
    document.getElementsByClassName('container')[1].classList.add('x');
    document.getElementsByClassName('container')[0].classList.remove('x');
  }

  signup( email: string, password: string) {
    this.authService.signup(email, password);
    this.message = this.authService.message;
    this.email = this.password = '';
  }
  logedin(email: string, password: string) {
    this.authService.login(email, password);
    this.message = this.authService.message;
    const payLoad = {
      email: this.email,
      password: this.password
    };
    this.email = this.password = '';
  }

  logout() {
    this.authService.logout();
  }
  ngOnInit() {
  }
}
