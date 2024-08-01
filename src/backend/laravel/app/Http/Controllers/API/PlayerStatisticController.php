<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlayerStatistic;


class PlayerStatisticController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/player_statustics/findAll",
     *     summary="List all player statistics",
     *     tags={"Player Statistics"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of player statistics",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PlayerStatistic")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $statistics = PlayerStatistic::with('player')->get();
        return response()->json($statistics);
    }

    /**
     * @OA\Post(
     *     path="/api/player_statustics/create",
     *     summary="Create a new player statistic",
     *     tags={"Player Statistics"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"player_id", "total_games", "wins", "losses", "goals_scored", "goals_against", "goal_difference"},
     *             @OA\Property(property="player_id", type="integer", example=1),
     *             @OA\Property(property="total_games", type="integer", example=10),
     *             @OA\Property(property="wins", type="integer", example=7),
     *             @OA\Property(property="losses", type="integer", example=3),
     *             @OA\Property(property="goals_scored", type="integer", example=25),
     *             @OA\Property(property="goals_against", type="integer", example=15),
     *             @OA\Property(property="goal_difference", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Player statistic created",
     *         @OA\JsonContent(ref="#/components/schemas/PlayerStatistic")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/player_statustics/findOne/{userId}",
     *     summary="Get a player statistic by ID",
     *     tags={"Player Statistics"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Player statistic details",
     *         @OA\JsonContent(ref="#/components/schemas/PlayerStatistic")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Player statistic not found"
     *     )
     * )
     */
    public function show($id)
    {
        $playerStatistic = PlayerStatistic::findOrFail($id);
        return response()->json($playerStatistic);
    }

    /**
     * @OA\Put(
     *     path="/api/player_statustics/update/{userId}",
     *     summary="Update a player statistic",
     *     tags={"Player Statistics"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="total_games", type="integer", example=12),
     *             @OA\Property(property="wins", type="integer", example=8),
     *             @OA\Property(property="losses", type="integer", example=4),
     *             @OA\Property(property="goals_scored", type="integer", example=30),
     *             @OA\Property(property="goals_against", type="integer", example=20),
     *             @OA\Property(property="goal_difference", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Player statistic updated",
     *         @OA\JsonContent(ref="#/components/schemas/PlayerStatistic")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Player statistic not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/player_statustics/delete/{userId}",
     *     summary="Delete a player statistic",
     *     tags={"Player Statistics"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Player statistic deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Player statistic not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $playerStatistic = PlayerStatistic::findOrFail($id);
        $playerStatistic->delete();
        return response()->json(null, 204);
    }
}
