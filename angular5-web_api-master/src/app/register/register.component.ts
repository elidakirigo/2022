import { Component, OnInit } from '@angular/core';
import {  NgForm } from '@angular/forms';
import { QuizService } from '../shared/quiz.service';
import { Route } from '@angular/compiler/src/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

 // EmailPattern = ' [a-z0-9._%+-]+@[a-z9.-]+\.[a-z]{2,4}$ ';
    EmailPattern = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$";

    
  constructor(private quizService: QuizService, private route: Router) { }

  onsubmit(name: string, email: string) { this.quizService.insertParticipant(name, email).subscribe(
    (data: any) => {
      localStorage.clear();
      localStorage.setItem('participant', JSON.stringify(data));

      this.route.navigate(['/quiz']); }
  ); }

  ngOnInit() {
  }

}
