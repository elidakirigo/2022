import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthGuard } from '../auth.guard';
import { AuthService } from '../utils/auth.service';

@Component({
  selector: 'app-logout',
  templateUrl: './logout.component.html',
  styleUrls: ['./logout.component.css']
})
export class LogoutComponent implements OnInit {

  constructor(private router: Router , private authService: AuthService) { }

  logout() {
    return this.authService.logout();
  }
  ngOnInit() {
  }
}
