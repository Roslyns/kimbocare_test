import { Routes } from "@angular/router";
import { HomeComponent } from "./views/home/home.component";
import { AuthAdminOrManagerGuard } from "./guards/auth-admin-or-manager.guard";
import { AuthEveryoneGuard } from "./guards/auth-everyone.guard";
import { StatisticsComponent } from "./views/statistics/statistics.component";
import { AuthAdminGuard } from "./guards/auth-admin.guard";
import { UnauthorizedComponent } from "./views/unauthorized/unauthorized.component";
import { LoginComponent } from "./views/pages/login/login.component";
import { appCanActivate } from "./guards/app.guard";
import { ScoresComponent } from "./views/scores/scores.component";

export const routes: Routes = [
    {
        path: '',
        component: LoginComponent,
        pathMatch: 'full',
    },
    {
        path: "main",
        // component: AppLayoutNavComponent,
        canActivate: [appCanActivate],
        children: [
            {
                path: 'home',
                component: HomeComponent,
                canActivate: [AuthAdminOrManagerGuard]
              },
              {
                path: 'scores',
                component: ScoresComponent,
                canActivate: [AuthEveryoneGuard]
              },
              {
                path: 'statistics',
                component: StatisticsComponent,
                canActivate: [AuthAdminGuard]
              },
              {
                path: 'unauthorized',
                component: UnauthorizedComponent
              },
        ]
    },
    {
        path: "**",
        redirectTo: ""
    }
  ];
