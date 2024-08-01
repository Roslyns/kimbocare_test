<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     required={"game_id", "player_id", "score"},
 *     @OA\Xml(name="Score"),
 *     @OA\Property(property="id", type="integer", readOnly=true, example="1"),
 *     @OA\Property(property="game_id", type="integer", description="ID of the game", example="1"),
 *     @OA\Property(property="player_id", type="integer", description="ID of the player", example="1"),
 *     @OA\Property(property="score", type="integer", description="Score of the player in the game", example="3"),
 *     @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 *     @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 *     @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 * Class Score
 * @package App\Models
 */
class Score extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'player_id',
        'score',
    ];

    /**
     * Get the game that the score belongs to.
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    /**
     * Get the player that the score belongs to.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
