import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { CartComponent } from './cart/cart.component';
import { ShopComponent } from './shop/shop.component';
import { LoginComponent } from './login/login.component';
import { AuthGuard } from './auth.guard';
import { LogoutComponent } from './logout/logout.component';


export const appRoutes: Routes = [
    { path: 'home', component: HomeComponent },
    { path: '', redirectTo: '/shop', pathMatch : 'full'},
    { path: 'cart', component: CartComponent ,
    // canActivate:[AuthGuard]
},
    // { path: '**', component: LoginComponent },
    { path: 'logout', component: LogoutComponent },
    { path: 'shop', component: ShopComponent },
    { path: 'login', component: LoginComponent }
];
