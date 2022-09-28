import { ShopComponent } from './shop/shop.component';

// tslint:disable-next-line: class-name
export class myCart {
    img: object;
    name: string;
    type: string;
    cost: number;
    totalCost: number;

    constructor() {
      this.img = Image;
    }

  }

export const CARTS: myCart[] = [
    {img : Image, name : 'elida', type : 'undefined' , cost : 30.00 , totalCost: 45.00}
];

// .addNewEmployeeForm() {
//   this.employees.push ({
//       name: '',
//       job: '',
//       about:''
//   })
// },
// deleteEmployeeForm(index) {
//   this.employees.splice (index, 1)
// }
