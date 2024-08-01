import { Component } from '@angular/core';
import { PlayerStatisticsService } from '../../services/player-statistics.service';
import { CommonModule } from '@angular/common';
import AppAuthService from '../../services/auth.service';

@Component({
  selector: 'app-statistics',
  standalone: true,
  imports: [
    CommonModule,
  ],
  templateUrl: './statistics.component.html',
  styleUrl: './statistics.component.scss'
})
export class StatisticsComponent {

  playerStatistics: any[] = [];

  constructor(
    private playerStatisticsService: PlayerStatisticsService,
    private authService: AppAuthService
  ) {}

  ngOnInit(): void {
    this.playerStatisticsService.findAll().subscribe(
      (data: any[]) => {
        this.playerStatistics = data;
      },
      (error) => {
        console.error('Failed to fetch player statistics', error);
      }
    );
  }

  logout(): void {
    this.authService.signout(); // Appeler la méthode signout de AppAuthService
  }

}
