// import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CookieService {
  readonly rootUrl = /*web api base project*/ 'http://localhost:2690';
  // constructor(private _http: HttpClient) { }
  setCookie(user :string , data : any) {
    localStorage.setItem(user, data)
  }
  clearCookie() {
    localStorage.clear()
  }
  removeCookie(user : string) {
    localStorage.removeItem(user)
  // }
  // insertName(name: string, email: string) {
  //   var body = { Name: name, Email: email };
  //   return this._http.post(this.rootUrl + '/api/InsertParticipant', body);
  }

}
