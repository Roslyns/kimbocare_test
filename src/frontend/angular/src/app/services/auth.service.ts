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

    authenticated = () => !!this.getToken();

    auth(auth: AppAuth): void {
        this.http
            .post(`${environment.apiUrl}/auth/login`, auth)
            .subscribe((result: any) => {
                if (!result || !result.access_token) return;
                localStorage.setItem("access_token", result.access_token);
                console.log(result.user.roles);
                
                localStorage.setItem("user_role", result.user.roles[0].name);
                if(result.user.roles[0].name === "ADMIN"){
                    this.router.navigate(["/main/statistics"]);
                } else if (result.user.roles[0].name === "MANAER"){
                    this.router.navigate(["/main/home"]);
                }else if (result.user.roles[0].name === "PLAYER"){
                    this.router.navigate(["/main/game"]);
                }
            });
    }

    signin = () => this.router.navigate(["/login"]);

    signout() {
        localStorage.clear();
        this.signin();
    }

    getToken = () => localStorage.getItem("access_token");

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