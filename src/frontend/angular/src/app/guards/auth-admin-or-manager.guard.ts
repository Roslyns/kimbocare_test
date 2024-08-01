import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import AppAuthService from '../services/auth.service';

@Injectable({
  providedIn: 'root'
})
export class AuthAdminOrManagerGuard implements CanActivate {
  constructor(private authService: AppAuthService, private router: Router) {}

  canActivate(): boolean {
    // if (this.authService.isAdmin() || this.authService.isManager()) {
      if (this.authService.isManager()) {
      return true;
    }
    this.router.navigate(['/unauthorized']);
    return false;
  }
}
