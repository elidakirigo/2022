import { Component } from '@angular/core';
import { Router, Event, NavigationStart, NavigationEnd, NavigationCancel, NavigationError } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  // title = 'angular CRUD TUTORIAL';

  showLoadingIndecator = true;

  // tslint:disable-next-line: variable-name
  constructor(private _router: Router) {
    this._router.events.subscribe((routerEvent: Event) => {

      if (routerEvent instanceof NavigationStart) {

        this.showLoadingIndecator = true;
      }
      if (routerEvent instanceof NavigationEnd || routerEvent instanceof NavigationCancel || routerEvent instanceof NavigationError) {

        this.showLoadingIndecator = false;
      }

    });
  }
}
