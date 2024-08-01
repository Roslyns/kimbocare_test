import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import AppAuthService from './services/auth.service';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const appAuthService = inject(AppAuthService);

    req = req.clone({
        setHeaders: { Authorization: `Bearer ${appAuthService.getToken()}` }
    });

    return next(req);
};
