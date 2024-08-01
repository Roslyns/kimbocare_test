<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Score;

class ScoreController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/scores/findAll",
     *     summary="Get list of scores",
     *     tags={"Scores"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Score"))
     *     )
     * )
     */
    public function index()
    {
        $scores = Score::all();
        return response()->json($scores);
    }

    /**
     * @OA\Post(
     *     path="/api/scores/create",
     *     summary="Create a new score",
     *     tags={"Scores"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"game_id", "player_id", "score"},
     *             @OA\Property(property="game_id", type="integer", example=1),
     *             @OA\Property(property="player_id", type="integer", example=2),
     *             @OA\Property(property="score", type="integer", example=100)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Score created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Score")
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
            'game_id' => 'required|exists:games,id',
            'player_id' => 'required|exists:users,id',
            'score' => 'required|integer',
        ]);

        $score = Score::create($validatedData);
        return response()->json($score, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/scores/findOne/{userId}",
     *     summary="Get a specific score",
     *     tags={"Scores"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Score")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Score not found"
     *     )
     * )
     */
    public function show($id)
    {
        $score = Score::findOrFail($id);
        return response()->json($score);
    }

    /**
     * @OA\Put(
     *     path="/api/scores/update/{userId}",
     *     summary="Update a score",
     *     tags={"Scores"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="game_id", type="integer", example=1, nullable=true),
     *             @OA\Property(property="player_id", type="integer", example=2, nullable=true),
     *             @OA\Property(property="score", type="integer", example=100, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Score updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Score")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Score not found"
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
            'game_id' => 'sometimes|required|exists:games,id',
            'player_id' => 'sometimes|required|exists:users,id',
            'score' => 'sometimes|required|integer',
        ]);

        $score = Score::findOrFail($id);
        $score->update($validatedData);
        return response()->json($score);
    }

    /**
     * @OA\Delete(
     *     path="/api/scores/delete/{userId}",
     *     summary="Delete a score",
     *     tags={"Scores"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Score deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Score not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $score = Score::findOrFail($id);
        $score->delete();
        return response()->json(null, 204);
    }
}
