<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;


class GameController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/games/findAll",
     *     summary="Get list of games",
     *     tags={"Games"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Game"))
     *     )
     * )
     */
    public function index()
    {
        $games = Game::all();
        return response()->json($games);
    }

    /**
     * @OA\Post(
     *     path="/api/games/create",
     *     summary="Create a new game",
     *     tags={"Games"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"player1_id", "player2_id"},
     *             @OA\Property(property="player1_id", type="integer", example=1),
     *             @OA\Property(property="player2_id", type="integer", example=2),
     *             @OA\Property(property="winner_id", type="integer", example=3, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Game created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
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
            'player1_id' => 'required|exists:users,id',
            'player2_id' => 'required|exists:users,id',
            'winner_id' => 'nullable|exists:users,id',
        ]);

        $game = Game::create($validatedData);
        return response()->json($game, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/games/findOne/{userId}",
     *     summary="Get a specific game",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game not found"
     *     )
     * )
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);
        return response()->json($game);
    }

    /**
     * @OA\Put(
     *     path="/api/games/update/{userId}",
     *     summary="Update a game",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="player1_id", type="integer", example=1, nullable=true),
     *             @OA\Property(property="player2_id", type="integer", example=2, nullable=true),
     *             @OA\Property(property="winner_id", type="integer", example=3, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game not found"
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
            'player1_id' => 'sometimes|required|exists:users,id',
            'player2_id' => 'sometimes|required|exists:users,id',
            'winner_id' => 'nullable|exists:users,id',
        ]);

        $game = Game::findOrFail($id);
        $game->update($validatedData);
        return response()->json($game);
    }

    /**
     * @OA\Delete(
     *     path="/api/games/delete/{userId}",
     *     summary="Delete a game",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Game deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();
        return response()->json(null, 204);
    }
}
