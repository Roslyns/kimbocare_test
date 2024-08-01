import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';
import AppAuthService from '../services/auth.service';

@Injectable({
  providedIn: 'root'
})
export class AuthAdminGuard implements CanActivate {

  constructor(private authService: AppAuthService, private router: Router) {}

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
    if (this.authService.isAdmin()) {
      return true;
    }
    this.router.navigate(['/unauthorized']);
    return false;
  }

}
