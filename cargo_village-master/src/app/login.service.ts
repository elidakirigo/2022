import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient, HttpParams , HttpHeaders } from '@angular/common/http';
import { map, catchError } from 'rxjs/operators';


@Injectable()

export class LoginService {

  constructor(private http: HttpClient) {

  }

  public baseUrl = 'http://167.99.137.54/api';

  public login(payload: any): Observable<any> {
        const loginUrl = '/auth/login';
        const fullUrl = this.baseUrl + loginUrl;
        const headers = new HttpHeaders({
          'Content-Type': 'application/json'
        });
        const jsonPayLoad = JSON.stringify(payload);
        return this.http.post(fullUrl, jsonPayLoad , {headers});
  }

}
