<?php

namespace Database\Factories;

use App\Models\PlayerStatistic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerStatisticFactory extends Factory
{
    protected $model = PlayerStatistic::class;

    public function definition(): array
    {
        $totalGames = $this->faker->numberBetween(1, 100);
        $wins = $this->faker->numberBetween(0, $totalGames);
        $losses = $totalGames - $wins;
        $goalsScored = $this->faker->numberBetween(0, 200);
        $goalsAgainst = $this->faker->numberBetween(0, 200);
        $goalDifference = $goalsScored - $goalsAgainst;

        return [
            'player_id' => User::inRandomOrder()->first()->id,
            'total_games' => $totalGames,
            'wins' => $wins,
            'losses' => $losses,
            'goals_scored' => $goalsScored,
            'goals_against' => $goalsAgainst,
            'goal_difference' => $goalDifference,
        ];
    }
}
