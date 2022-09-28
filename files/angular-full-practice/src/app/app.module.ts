import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { AdminComponent } from './admin/admin.component';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { UserComponent } from './user/user.component';
import { appRoutes } from './routes';
import { AuthGuard } from './auth/auth.guard';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    AdminComponent,
    UserComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    RouterModule.forRoot(appRoutes, /* {enableTracing : true} */)

  ],
  providers: [AuthGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }
