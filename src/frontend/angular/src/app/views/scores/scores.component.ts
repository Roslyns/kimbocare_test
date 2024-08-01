import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { ScoreService } from '../../services/score.service';
import AppAuthService from '../../services/auth.service';

@Component({
  selector: 'app-scores',
  standalone: true,
  imports: [
    CommonModule
  ],
  templateUrl: './scores.component.html',
  styleUrl: './scores.component.scss'
})
export class ScoresComponent {
  scores: any[] = [];

  constructor(
    private scoreService: ScoreService,
    private authService: AppAuthService
  ) {}

  ngOnInit(): void {
    this.scoreService.findAll().subscribe(
      (data: any[]) => {
        this.scores = data;
      },
      (error) => {
        console.error('Failed to fetch scores', error);
      }
    );
  }

  logout(): void {
    this.authService.signout(); // Appeler la méthode signout de AppAuthService
  }
}
