import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChanges } from '@angular/core';
import { Employee } from '../models/employee.model';
import { ActivatedRoute, Router } from '@angular/router';
import { EmployeeService } from './employee.service';

@Component({
  selector: 'app-display-employee',
  templateUrl: './display-employee.component.html',
  styleUrls: ['./display-employee.component.css']
})
export class DisplayEmployeeComponent implements OnInit, OnChanges {

  // @Input() employeeId: number;

  @Input() employee: Employee;

  @Output() notify: EventEmitter<Employee> = new EventEmitter<Employee>();

  @Input() searchTerm: string;

  @Output() notifyDelete : EventEmitter<number> = new EventEmitter<number>();

  confirmDelete = false;

  // panelExpanded = true;

  isHidden = false;

  // tslint:disable-next-line: variable-name
  private _employee: Employee;

  private selectedEmployeeId: number;

  // @Input()

  // set employee(val: Employee) {
  //   this._employee = val;
  // }

  // get employee(): Employee {
  //   return this._employee;
  // }

  // tslint:disable-next-line: variable-name
  constructor(private _employeeSrevice: EmployeeService, private _route: ActivatedRoute, private _router: Router) { }

  ngOnInit() {
    this.selectedEmployeeId = +this._route.snapshot.paramMap.get('id');
  }

  ngOnChanges(changes: SimpleChanges) {
    // //console.log(changes);

    //   const previousEmployee = changes.employee.previousValue as Employee;
    //   const currentEmployee = changes.employee.currentValue as Employee;

    // console.log(previousEmployee ? previousEmployee.name : 'null' );

    for (const propName of Object.keys(changes)) {
      // console.log(propName);
      const change = changes[propName];
      const from = JSON.stringify(change.previousValue);
      const to = JSON.stringify(change.currentValue);
      // console.log(propName + ' from : ' + from + ' to : ' + to);


    }
  }

  viewEmployee() {
    this._router.navigate(['/employees', this.employee.id], {
      // tslint:disable-next-line: object-literal-key-quotes
      queryParams: { 'searchTerm': this.searchTerm }
    });
  }

  editEmployee() {

    this._router.navigate(['/edit', this.employee.id]);

  }

  deleteEmployee() {

    this._employeeSrevice.deleteEmployee(this.employee.id);

    this.notifyDelete.emit(this.employee.id);

  }
  handleClick() {
    this.notify.emit(this.employee);
  }
}
