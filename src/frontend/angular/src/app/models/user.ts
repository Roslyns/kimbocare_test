import AppAuth from "./auth";

export default interface AppUser {
    id: number;
    name: string;
    email: string;
    auth: AppAuth;
    roles?: any [];
    permissions?: any [];
}