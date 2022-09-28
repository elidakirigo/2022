import { Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { UserComponent } from './user/user.component';
import { AdminComponent } from './admin/admin.component';
import { AuthGuard } from './auth/auth.guard';

export const appRoutes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'home', component: HomeComponent },
    { path: 'user', component: UserComponent, canActivate : [AuthGuard]},
    { path: 'admin', component: AdminComponent ,canActivate : [AuthGuard]},
    { path: '', redirectTo: '/home', pathMatch: 'full' }
  ];
  