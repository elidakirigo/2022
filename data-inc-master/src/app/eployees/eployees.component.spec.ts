import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EployeesComponent } from './eployees.component';

describe('EployeesComponent', () => {
  let component: EployeesComponent;
  let fixture: ComponentFixture<EployeesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EployeesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EployeesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
