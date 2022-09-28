import { Injectable } from '@angular/core';
import { Employee } from '../models/employee.model';
import { Observable, of } from 'rxjs';
import 'rxjs/add/operator/delay';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import { catchError } from 'rxjs/operators';
import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { ErrorObservable } from 'rxjs/observable/ErrorObservable';

@Injectable()

export class EmployeeService {

  constructor(private httpClient: HttpClient) { }
  private listEmployees: Employee[] = [
    {
      id: 1,
      name: 'Mark',
      gender: 'Male',
      email: 'mark@pragimtech.com',
      phoneNumber: 324563,
      ContactPreference: 'Email',
      dateOfBirth: new Date('10/25/1998'),
      department: 3,
      isActive: true,
      photoPath: 'assets/images/person1.jpg'
    },
    {
      id: 2,
      name: 'mary',
      gender: 'Female',
      phoneNumber: 7867899,
      ContactPreference: 'Phone',
      dateOfBirth: new Date('11/2/3432'),
      department: 2,
      isActive: true,
      photoPath: 'assets/images/person2.jpg'
    },
    {
      id: 3,
      name: 'john',
      gender: 'Male',
      phoneNumber: 456432,
      ContactPreference: 'Phone',
      dateOfBirth: new Date('3/24/1995'),
      department: 3,
      isActive: false,
      photoPath: 'assets/images/person3.jpg',
    }
  ];

  baseUrl = 'http://localhost:3000/employees';

  getEmployees(): Observable<Employee[]> {

    // return of(this.listEmployees).delay(2000);
    return this.httpClient.get<Employee[]>('http://localhost:3000/employees').catch(this.handleError);
  }

  getEmployee(id: number): Observable<Employee> {

    // return this.listEmployees.find(e => e.id === id);
    return this.httpClient.get<void>(`${this.baseUrl}/${employee.id}`).pipe(catchError(this.handleError));

  }

  private handleError(errorResponse: HttpErrorResponse) {

    if (errorResponse.error instanceof ErrorEvent) {

      console.error(errorResponse.error.message, errorResponse);

    } else {
      console.error(errorResponse);

    }

    return new ErrorObservable('theres a problem with a server we are notified and get to it');
  }

  addEmployee(employee: Employee): Observable<Employee> {


    return this.httpClient.post<Employee>('http://localhost:3000/employees', employee, {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    }).pipe(catchError(this.handleError));

    // if (employee.id == null) {
    // tslint:disable-next-line: only-arrow-functions
    // const maxid = this.listEmployees.reduce(function(e1, e2) {
    //   return (e1.id > e2.id) ? e1 : e2;
    // }).id;
    // employee.id = maxid + 1;
    // this.listEmployees.push(employee);
    // } else {

    //   const foundIndex = this.listEmployees.findIndex(e => e.id === employee.id);

    //   this.listEmployees[foundIndex] = employee;
    // }
  }

  updateEmployee(employee: Employee): Observable<void> {

    return this.httpClient.put<void>(`${this.baseUrl}/${employee.id}`, employee, {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    }).pipe(catchError(this.handleError));

  }

  deleteEmployee(id: number) {
    const i = this.listEmployees.findIndex(e => e.id === id);

    if (i !== -1) {
      this.listEmployees.splice(i, 1);
    }
  }
}
