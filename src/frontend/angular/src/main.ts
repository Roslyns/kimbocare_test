import { bootstrapApplication } from '@angular/platform-browser';
import { appConfig } from './app/app.config';
import { AppComponent } from './app/app.component';
import { environment } from './environments/environment';
import { enableProdMode } from '@angular/core';

if (environment.production) {
  enableProdMode();
}

console.log(`le mode de l pp est : ${environment.production}`);

bootstrapApplication(AppComponent, appConfig)
  .catch((err) => console.error(err));
