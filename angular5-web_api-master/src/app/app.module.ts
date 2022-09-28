import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';

import { QuizComponent } from './quiz/quiz.component';
import { RegisterComponent } from './register/register.component';
import { AppComponent } from './app.component';
import { NavbarComponent } from './navbar/navbar.component';
import { ResultComponent } from './result/result.component';
import { RouterModule } from '@angular/router';
import { appRoutes } from './routes';
import { HttpClientModule } from '@angular/common/http';
import { QuizService } from './shared/quiz.service';

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    ResultComponent,
    RegisterComponent,
    QuizComponent
  ],
  imports: [
    BrowserModule,
    RouterModule.forRoot(appRoutes),
    FormsModule,
    HttpClientModule
  ],
  providers: [QuizService],
  bootstrap: [AppComponent]
})
export class AppModule { }
