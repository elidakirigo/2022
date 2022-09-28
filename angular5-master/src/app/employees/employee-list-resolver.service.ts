import { Resolve, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Employee } from '../models/employee.model';
import { Observable } from 'rxjs';
import { EmployeeService } from './employee.service';
import { Injectable } from '@angular/core';
import { map , catchError } from 'rxjs/operators';
import { ResolvedEmployeeList } from './resolved-employeeList.model';

@Injectable()

export class EmployeeListResolverService implements Resolve<ResolvedEmployeeList[] | string > {

    // tslint:disable-next-line: variable-name
    constructor(private _employeeService: EmployeeService) { }
    resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<Employee[] | string > {
        return this._employeeService.getEmployees()
            .pipe(
                // map((employeeList) => new ResolvedEmployeeList(employeeList))
                catchError((err: string) => Observable.of( err))
                );
    }
}