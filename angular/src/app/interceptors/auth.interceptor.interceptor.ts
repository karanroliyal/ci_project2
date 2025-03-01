import { HttpEvent, HttpHandlerFn, HttpInterceptorFn, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs/internal/Observable';

export function AuthInterceptor(req: HttpRequest<unknown>, next: HttpHandlerFn): Observable<HttpEvent<unknown>> {
  // Clone the request to add the authentication header.

  const authToken = localStorage.getItem('auth_token')

  // console.log(authToken);

  const newReq = req.clone({
    headers: req.headers.set('authorization', `${authToken}`),
  });
  
  return next(newReq);
}
