<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Score;

class ScoreController extends Controller
{
    /**
     * Display a listing of the scores.
     */
    public function index()
    {
        $scores = Score::all();
        return response()->json($scores);
    }

    /**
     * Store a newly created score in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|exists:games,id',
            'player_id' => 'required|exists:users,id',
            'score' => 'required|integer',
        ]);

        $score = Score::create($validatedData);
        return response()->json($score, 201);
    }

    /**
     * Display the specified score.
     */
    public function show($id)
    {
        $score = Score::findOrFail($id);
        return response()->json($score);
    }

    /**
     * Update the specified score in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'game_id' => 'sometimes|required|exists:games,id',
            'player_id' => 'sometimes|required|exists:users,id',
            'score' => 'sometimes|required|integer',
        ]);

        $score = Score::findOrFail($id);
        $score->update($validatedData);
        return response()->json($score);
    }

    /**
     * Remove the specified score from storage.
     */
    public function destroy($id)
    {
        $score = Score::findOrFail($id);
        $score->delete();
        return response()->json(null, 204);
    }
}
