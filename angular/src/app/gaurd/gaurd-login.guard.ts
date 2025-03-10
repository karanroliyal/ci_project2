import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';

export const gaurdLoginGuard: CanActivateFn = (route, state) => {

  const router = inject(Router);

  let Token = localStorage.getItem('secure_token');
  let Auth_Token = localStorage.getItem('auth_token');


  if (Token !== '' || Auth_Token !== '') {
    router.navigate(['dash/dashboard'])
    return false
  }

  return true;
};
