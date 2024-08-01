<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     required={"player_id", "total_games", "wins", "losses", "goals_scored", "goals_against", "goal_difference"},
 *     @OA\Xml(name="PlayerStatistic"),
 *     @OA\Property(property="id", type="integer", readOnly=true, example="1"),
 *     @OA\Property(property="player_id", type="integer", description="ID of the player", example="1"),
 *     @OA\Property(property="total_games", type="integer", description="Total number of games played", example="100"),
 *     @OA\Property(property="wins", type="integer", description="Number of games won", example="60"),
 *     @OA\Property(property="losses", type="integer", description="Number of games lost", example="40"),
 *     @OA\Property(property="goals_scored", type="integer", description="Total number of goals scored", example="150"),
 *     @OA\Property(property="goals_against", type="integer", description="Total number of goals against", example="100"),
 *     @OA\Property(property="goal_difference", type="integer", description="Difference between goals scored and goals against", example="50"),
 *     @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 *     @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 *     @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 * Class PlayerStatistic
 * @package App\Models
 */
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
