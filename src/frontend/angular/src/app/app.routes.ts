import { Routes } from "@angular/router";
import { HomeComponent } from "./views/home/home.component";
import { AuthAdminOrManagerGuard } from "./guards/auth-admin-or-manager.guard";
import { AuthEveryoneGuard } from "./guards/auth-everyone.guard";
import { GameComponent } from "./views/game/game.component";
import { StatisticsComponent } from "./views/statistics/statistics.component";
import { AuthAdminGuard } from "./guards/auth-admin.guard";
import { UnauthorizedComponent } from "./views/unauthorized/unauthorized.component";
import { LoginComponent } from "./views/pages/login/login.component";
import { appCanActivate } from "./guards/app.guard";

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
                path: 'game',
                component: GameComponent,
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
