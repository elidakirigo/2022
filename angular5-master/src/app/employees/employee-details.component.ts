import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { EmployeeService } from './employee.service';
import { Employee } from '../models/employee.model';

@Component({
  selector: 'app-employee-details',
  templateUrl: './employee-details.component.html',
  styleUrls: ['./employee-details.component.css']
})
export class EmployeeDetailsComponent implements OnInit {

  // tslint:disable-next-line: variable-name
  private _id: number;

  employee: Employee;
  // tslint:disable-next-line: variable-name
  constructor(private _router: Router, private _route: ActivatedRoute, private _employeeService: EmployeeService) { }

  ngOnInit() {

    // tslint:disable-next-line: no-string-literal
    this._route.paramMap.subscribe(params => {
      this._id = +params.get('id');

      this.employee = this._employeeService.getEmployee(this._id);

    });
  }

  viewNextEmployee() {

    if (this._id < 3) {

      this._id = this._id + 1;

    } else {

      this._id = 1;

    }

    this._router.navigate(['/employees', this._id], {

      queryParamsHandling: 'preserve' 

    });
  }
}
