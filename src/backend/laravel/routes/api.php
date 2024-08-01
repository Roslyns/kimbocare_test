<?php

// third party libs...
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controllers
use App\Http\Controllers\API\AuthController;



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


Route::prefix('auth')->group(function () {
    
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('jwt.verify')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('user', [AuthController::class, 'user']);
    });
});
