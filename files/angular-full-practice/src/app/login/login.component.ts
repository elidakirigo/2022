import { Component, OnInit } from '@angular/core';
import { CookieService } from '../utils/cookie.service';
import { Router } from '@angular/router';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  constructor(public cookieService: CookieService,
    public route: Router) { }
  saveLogin(formtype: NgForm): void {
    this.cookieService.clearCookie()
    this.cookieService.setCookie('participant', JSON.stringify(formtype.value))
    this.route.navigate(['admin'])
  }
  saveSignUp(formtype: NgForm): void {
    console.log(formtype.value);

  }
  ngOnInit() {
  }

}
