import { HttpEvent, HttpHandlerFn, HttpInterceptorFn, HttpRequest } from '@angular/common/http';
import { inject } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs/internal/Observable';

export function AuthInterceptor(req: HttpRequest<unknown>, next: HttpHandlerFn): Observable<HttpEvent<unknown>> {
  

  const authToken = localStorage.getItem('auth_token');

  const router = inject(Router);

  console.log(router.url , 'my header injector')

  const newReq = req.clone({
    headers: req.headers.set('authorization', `${authToken}`)
    .set('myurl' , router.url )
  });
  
  return next(newReq);
}
