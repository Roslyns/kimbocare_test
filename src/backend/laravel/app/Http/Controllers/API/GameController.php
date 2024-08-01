<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Game;

class GameController extends Controller
{
    /**
     * Display a listing of the games.
     */
    public function index()
    {
        $games = Game::all();
        return response()->json($games);
    }

    /**
     * Store a newly created game in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'player1_id' => 'required|exists:users,id',
            'player2_id' => 'required|exists:users,id',
            'winner_id' => 'nullable|exists:users,id',
        ]);

        $game = Game::create($validatedData);
        return response()->json($game, 201);
    }

    /**
     * Display the specified game.
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);
        return response()->json($game);
    }

    /**
     * Update the specified game in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'player1_id' => 'sometimes|required|exists:users,id',
            'player2_id' => 'sometimes|required|exists:users,id',
            'winner_id' => 'nullable|exists:users,id',
        ]);

        $game = Game::findOrFail($id);
        $game->update($validatedData);
        return response()->json($game);
    }

    /**
     * Remove the specified game from storage.
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();
        return response()->json(null, 204);
    }
}
