<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PlayerStatistic;

class PlayerStatisticController extends Controller
{
    /**
     * Display a listing of the player statistics.
     */
    public function index()
    {
        $playerStatistics = PlayerStatistic::all();
        return response()->json($playerStatistics);
    }

    /**
     * Store a newly created player statistic in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'player_id' => 'required|exists:users,id',
            'total_games' => 'required|integer',
            'wins' => 'required|integer',
            'losses' => 'required|integer',
            'goals_scored' => 'required|integer',
            'goals_against' => 'required|integer',
            'goal_difference' => 'required|integer',
        ]);

        $playerStatistic = PlayerStatistic::create($validatedData);
        return response()->json($playerStatistic, 201);
    }

    /**
     * Display the specified player statistic.
     */
    public function show($id)
    {
        $playerStatistic = PlayerStatistic::findOrFail($id);
        return response()->json($playerStatistic);
    }

    /**
     * Update the specified player statistic in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'total_games' => 'sometimes|required|integer',
            'wins' => 'sometimes|required|integer',
            'losses' => 'sometimes|required|integer',
            'goals_scored' => 'sometimes|required|integer',
            'goals_against' => 'sometimes|required|integer',
            'goal_difference' => 'sometimes|required|integer',
        ]);

        $playerStatistic = PlayerStatistic::findOrFail($id);
        $playerStatistic->update($validatedData);
        return response()->json($playerStatistic);
    }

    /**
     * Remove the specified player statistic from storage.
     */
    public function destroy($id)
    {
        $playerStatistic = PlayerStatistic::findOrFail($id);
        $playerStatistic->delete();
        return response()->json(null, 204);
    }
}
