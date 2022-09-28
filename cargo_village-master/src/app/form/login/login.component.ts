import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../login.service';
import { LocalStorageService } from '../../utils/local-storage.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  public email: string;
  public password: string;
  public message = {
     'text': ''
  };
  constructor(private  _loginService: LoginService,
  private _localStorageService: LocalStorageService,
  private _router: Router) { }

  ngOnInit() {
  }

  public submitLogin() {
     this.message = {
       'text': ''
     };
     const payLoad = {
       'email': this.email,
       'password': this.password
     };
     this._loginService.login(payLoad).subscribe((success) => {
        console.log('Success', success);
        this._localStorageService.setItem('access_token', success.access_token);
        this._router.navigate(['../admin']);
     }, (error) => {
       this.message = {
          'text' : 'Invalid Email/Password.PLease try again'
       };
       console.log('Error', error);
     });
  }

}
