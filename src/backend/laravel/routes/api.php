<?php

// third party libs...
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controllers
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\ScoreController;
use App\Http\Controllers\API\PlayerStatisticController;



/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. The following routes are
| available for authentication purposes:
|
| - **POST /api/auth/login**: Logs in a user and returns a JWT token.
| - **POST /api/auth/register**: Registers a new user and returns the user details along with a JWT token.
| - **POST /api/auth/logout**: Invalidates the JWT token and logs out the user. Requires authentication.
| - **POST /api/auth/user**: Retrieves details of the authenticated user. Requires authentication.
|
| Routes requiring authentication are protected by the `jwt.verify` middleware,
| ensuring that the user must provide a valid JWT token to access these endpoints.
|
*/

// auth routes
Route::prefix('auth')->group(function () {
    
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('jwt.verify')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('user', [AuthController::class, 'user']);
    });
});


Route::middleware('jwt.verify')->group(function () {

    // games
    Route::middleware('role:' . MANAER_ROLE['name'])->group(function () {
        Route::prefix('games')->group(function () {
            Route::get('/findAll', [GameController::class, 'index']);
            Route::get('/findOne/{userId}', [GameController::class, 'show']);
            Route::post('/create', [GameController::class, 'store']);
            Route::put('/update/{userId}', [GameController::class, 'update']);
            Route::delete('/delete/{userId}', [GameController::class, 'destroy']);
        });        
    });

    // scores
    Route::middleware('role:' . PLAYER_ROLE['name'])->group(function () {
        Route::prefix('scores')->group(function () {
            Route::get('/findAll', [ScoreController::class, 'index']);
            Route::get('/findOne/{userId}', [ScoreController::class, 'show']);
            Route::post('/create', [ScoreController::class, 'store']);
            Route::put('/update/{userId}', [ScoreController::class, 'update']);
            Route::delete('/delete/{userId}', [ScoreController::class, 'destroy']);
        });        
    });
    
    // player statistics
    Route::middleware('role:' . ADMIN_ROLE['name'])->group(function () {
        Route::prefix('player_statustics')->group(function () {
            Route::get('/findAll', [PlayerStatisticController::class, 'index']);
            Route::get('/findOne/{userId}', [PlayerStatisticController::class, 'show']);
            Route::post('/create', [PlayerStatisticController::class, 'store']);
            Route::put('/update/{userId}', [PlayerStatisticController::class, 'update']);
            Route::delete('/delete/{userId}', [PlayerStatisticController::class, 'destroy']);
        });        
    });
    

});

