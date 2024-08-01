<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     required={"player1_id", "player2_id"},
 *     @OA\Xml(name="Game"),
 *     @OA\Property(property="id", type="integer", readOnly=true, example="1"),
 *     @OA\Property(property="player1_id", type="integer", description="ID of the first player", example="1"),
 *     @OA\Property(property="player2_id", type="integer", description="ID of the second player", example="2"),
 *     @OA\Property(property="winner_id", type="integer", description="ID of the winner", example="1", nullable=true),
 *     @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 *     @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 *     @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 * Class Game
 * @package App\Models
 */
class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player1_id',
        'player2_id',
        'winner_id',
    ];

    /**
     * Get the user that is player 1.
     */
    public function player1()
    {
        return $this->belongsTo(User::class, 'player1_id');
    }

    /**
     * Get the user that is player 2.
     */
    public function player2()
    {
        return $this->belongsTo(User::class, 'player2_id');
    }

    /**
     * Get the user that is the winner.
     */
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }
}
