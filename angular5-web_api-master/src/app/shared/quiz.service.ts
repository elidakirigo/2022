import { Injectable } from '@angular/core';
// import { HttpClient } from 'selenium-webdriver/http';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class QuizService {
// ............properties......
readonly rootUrl = /*web api base projecct*/ 'http://localhost:2690';

insertParticipant(name: string, email: string) {
  var body = { Name : name, Email: email};
  return this.http.post(this.rootUrl + '/api/InsertParticipant', body);
}

// ............helper method...........
  constructor(private http: HttpClient) { }



  // .......http methods...
}
