import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class LocalStorageService {

  constructor() { }

  public setItem(key: string , value: any) {
      window.localStorage.setItem(key , value);
  }

  public getItem() {

  }

  public removeItem() {

  }

  public clear() {

  }
}
