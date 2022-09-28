import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './form/login/login.component';
import { AdminComponent } from './admin/admin.component';
import { FormsModule } from '@angular/forms';
import { FormComponent } from './form/form.component';
import { SignupComponent } from './form/signup/signup.component';
import { VehicleOwnerComponent } from './vehicle-owner/vehicle-owner.component';
import { ConsignorComponent } from './consignor/consignor.component';
import { DriverComponent } from './driver/driver.component';

export const appRoutes: Routes = [
  { path: 'home', component: HomeComponent , /* canActivate: AuthGuard */ },
  { path: '', redirectTo: '/home', pathMatch : 'full'},
//  { path: '**', component: HomeComponent },
  { path: 'admin', component: AdminComponent, },
  { path: 'login', component: FormComponent },
  { path: 'signup', component: FormComponent },
  { path: 'admin', component: AdminComponent },
  { path: 'vehicle-owner', component: VehicleOwnerComponent},
  {path: 'consignor', component: ConsignorComponent},
  { path: 'driver', component: DriverComponent},
];

