import { Component } from '@angular/core';
import { PlayerStatisticsService } from '../../services/player-statistics.service';
import { CommonModule } from '@angular/common';

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

  constructor(private playerStatisticsService: PlayerStatisticsService) {}

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

}
