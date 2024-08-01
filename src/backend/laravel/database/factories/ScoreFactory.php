<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Score;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    protected $model = Score::class;

    public function definition()
    {
        return [
            'game_id' => Game::inRandomOrder()->first()->id,
            'player_id' => User::inRandomOrder()->first()->id,
            'score' => $this->faker->numberBetween(0, 10),
        ];
    }
}
