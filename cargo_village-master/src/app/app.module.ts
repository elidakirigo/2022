import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { from } from 'rxjs';

import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { AdminComponent } from './admin/admin.component';
import { appRoutes } from './routes';
import { LoginComponent } from './form/login/login.component';
import { FormComponent } from './form/form.component';
import { SignupComponent } from './form/signup/signup.component';
import { ConsignorComponent } from './consignor/consignor.component';
import { DriverComponent } from './driver/driver.component';
import { LoginService } from './login.service';
import { VehicleOwnerComponent } from './vehicle-owner/vehicle-owner.component';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    AdminComponent,
    LoginComponent,
    FormComponent,
    SignupComponent,
    ConsignorComponent,
    DriverComponent,
    VehicleOwnerComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    RouterModule.forRoot(appRoutes),
    HttpClientModule,
  ],
  providers: [// UserService,
    LoginService
  ],

  bootstrap: [AppComponent]
})
export class AppModule { }
