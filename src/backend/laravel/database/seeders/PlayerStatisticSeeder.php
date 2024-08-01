<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlayerStatistic;

class PlayerStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assurez-vous que les utilisateurs existent déjà dans la base de données
        $playerCount = \App\Models\User::count();

        if ($playerCount > 0) {
            PlayerStatistic::factory()->count(15)->create();
        } else {
            $this->command->warn('No users found. Please seed the users table first.');
        }
    }
}
