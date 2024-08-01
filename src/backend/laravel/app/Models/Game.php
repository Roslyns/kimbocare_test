<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
