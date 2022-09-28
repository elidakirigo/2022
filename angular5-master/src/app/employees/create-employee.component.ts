import { Component, OnInit, ViewChild } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Department } from '../models/department.model';
import { Employee } from '../models/employee.model';
import { BsDatepickerConfig } from 'ngx-bootstrap/datepicker';
import { Router, ActivatedRoute } from '@angular/router';
import { EmployeeService } from './employee.service';

@Component({
  selector: 'app-create-employee',
  templateUrl: './create-employee.component.html',
  styleUrls: ['./create-employee.component.css']
})
export class CreateEmployeeComponent implements OnInit {

  @ViewChild('employeeForm', { static: false }) public createEmployeeForm: NgForm;


  // tslint:disable-next-line: variable-name
  constructor(private _route: ActivatedRoute, private _employeeService: EmployeeService, private _router: Router) {
    this.datePickeConfig = Object.assign({}, {
      containerClass: 'theme-dark-blue',
      showWeekNumbers: false,
      minDate: new Date(2018, 0, 1),
      maxDate: new Date(2019, 11, 31),
      dateInputFormat: 'DD/MM/YYYY'
    });
  }

  panelTitle: string;

  gender = 'Male';

  isActive = true;

  department = 3;

  datePickeConfig: Partial<BsDatepickerConfig>;

  dateOfBirth: Date = new Date(2018, 0, 30);

  previewPhoto = false;

  EmailPattern = '^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$';

  employee: Employee = {
    id: null,
    name: null,
    gender: null,
    email: null,
    phoneNumber: null,
    ContactPreference: null,
    dateOfBirth: null,
    department: -1,
    isActive: null,
    photoPath: null
  };

  departments: Department[] = [
    { id: 1, name: 'help desk' },
    { id: 2, name: 'HR' },
    { id: 3, name: 'IT' },
    { id: 4, name: 'payroll' }

  ];

  togglePhotoPreview() {
    this.previewPhoto = !this.previewPhoto;
  }

  ngOnInit() {

    this._route.paramMap.subscribe(parameterMap => {

      const id = +parameterMap.get('id');

      this.getEmployee(id);
    });
  }
  private getEmployee(id: number) {

    if (id === 0) {
      this.employee = {
        id: null,
        name: null,
        gender: null,
        email: null,
        phoneNumber: null,
        ContactPreference: null,
        dateOfBirth: null,
        department: -1,
        isActive: null,
        photoPath: null
      };
      this.panelTitle = 'create employee';
    } else {
      this.panelTitle = 'edit employee';

      this.createEmployeeForm.reset();
      this.employee = Object.assign({}, this._employeeService.getEmployee(id));

    }
  }

  saveEmployee(): void {

    // console.log(newEmployee);
    // const newEmployee: Employee = Object.assign({}, this.employee);

    this._employeeService.save(this.employee).subscribe(
      (data: Employee) => {
        console.log(data);
        this.createEmployeeForm.reset();
        this._router.navigate(['list']);
      },
      (error: any) => console.log(error)
    );

    // this._employeeService.save(this.employee);

    // this.createEmployeeForm.reset(/* { name: 'TestName', contactPreference: 'phone'} */);

    // empForm.reset();

  }
}
