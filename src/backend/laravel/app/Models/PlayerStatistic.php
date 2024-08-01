<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerStatistic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'total_games',
        'wins',
        'losses',
        'goals_scored',
        'goals_against',
        'goal_difference',
    ];

    /**
     * Get the player that the statistics belong to.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
