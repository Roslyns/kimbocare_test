<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition()
    {
        $player1 = User::factory()->create();
        $player2 = User::factory()->create();

        // Ensure player1 and player2 are different
        while ($player1->id === $player2->id) {
            $player2 = User::factory()->create();
        }

        // Randomly choose a winner or set to null
        $winner = $this->faker->boolean ? $this->faker->randomElement([$player1->id, $player2->id]) : null;

        return [
            'player1_id' => $player1->id,
            'player2_id' => $player2->id,
            'winner_id' => $winner,
        ];
    }
}
