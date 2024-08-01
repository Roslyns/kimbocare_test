import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, map, tap } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ScoreService {

  constructor(
    private readonly http: HttpClient,
    private readonly router: Router) { }

  findAll(): Observable<any> {
    return this.http.get<any>(`${environment.apiUrl}/scores/findAll`)
    .pipe(
      tap((result: any) => {
        if (!result) return;
      }),
      map((response: any) => response))
  }
}
