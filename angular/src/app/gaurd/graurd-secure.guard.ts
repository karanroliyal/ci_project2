import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';

export const graurdSecureGuard: CanActivateFn = (route, state) => {

  const router = inject(Router);

  let Token = localStorage.getItem('secure_token');

  if(Token == ''){
    router.navigate(['/login'])
    return false
  }

  return true;
};
