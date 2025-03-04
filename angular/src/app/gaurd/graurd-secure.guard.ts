import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { filter } from 'rxjs';

export const graurdSecureGuard: CanActivateFn = (route, state) => {

  const router = inject(Router);

  let menuArray: any = localStorage.getItem('menu');

  menuArray = JSON.parse(menuArray);

  
  let checkMenuArray = menuArray.some((ele:any)=>ele.route === '/dash/dashboard');
  

  let Token = localStorage.getItem('secure_token');
  let Auth_Token = localStorage.getItem('auth_token');

  if(Token == '' || Auth_Token == ''){
    router.navigate(['/login']);
    localStorage.setItem('secure_token' , '');
    localStorage.setItem('auth_token' , '');
    return false
  }

  return true;
};
