import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Router } from "@angular/router";
import AppAuth from "../models/auth";
import { environment } from "../../environments/environment";

// import { environment } from './environments/environment';


@Injectable({ providedIn: "root" })
export default class AppAuthService {

    constructor(
        private readonly http: HttpClient,
        private readonly router: Router) { }

    authenticated = () => !!this.token();

    auth(auth: AppAuth): void {
        this.http
            .post(`${environment.apiUrl}/login`, auth)
            .subscribe((result: any) => {
                if (!result || !result.token) return;
                localStorage.setItem("access_token", result.access_token);
                localStorage.setItem("user_role", result.roles[0].name);
                this.router.navigate(["/home"]);
            });
    }

    signin = () => this.router.navigate(["/auth"]);

    signout() {
        localStorage.clear();
        this.signin();
    }

    token = () => localStorage.getItem("access_token");

    isAdmin(): boolean {
        const storedRole = localStorage.getItem("user_role");
        if (storedRole) {
            return storedRole === 'ADMIN';
        }
        this.signout();
        return false;
    }
    
    isManager(): boolean {
        const storedRole = localStorage.getItem("user_role");
        if (storedRole) {
            return storedRole === 'MANAER';
        }
        this.signout();
        return false;
    }
    
    isPlayer(): boolean {
        const storedRole = localStorage.getItem("user_role");
        if (storedRole) {
            return storedRole === 'PLAYER';
        }
        this.signout();
        return false;
    }
}