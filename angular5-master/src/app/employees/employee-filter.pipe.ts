import { Employee } from '../models/employee.model';
import { PipeTransform, Pipe } from '@angular/core';

@Pipe({
  name: 'employeeFilter',
  pure: false
})
export class EmployeeFilterPipe implements PipeTransform {

  private counter = 0;
  transform(employees: Employee[], searchTerm: string): Employee[] {

    this.counter++;
    //console.log(this.counter);

    if (!employees || !searchTerm) {
      return employees;
    }
    return employees.filter(employee => employee.name.toLocaleLowerCase().indexOf(searchTerm.toLocaleLowerCase()) !== -1);
  }
}
