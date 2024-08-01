<?php

namespace App\Http\Controllers\API;

use Tymon\JWTAuth\Facades\JWTAuth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register",
     *     description="Register a new user",
     *     operationId="authRegister",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password", "username"},
     *             @OA\Property(property="username", type="string", example="maestros22"),
     *             @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *             @OA\Property(property="email", type="string", format="email", example="maestros22@gmail.com"),
     *             @OA\Property(property="name", type="string", format="email", example="Maestros Roslyn"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User successfully created"),
     *             @OA\Property(
     *                   property="content",
     *                   type="object",
     *                   @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *              ),
     *           )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error - Invalid request data",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object", example={
     *                 "username": {
     *                     "Le username est un champ requis."
     *                 },
     *                 "password": {
     *                     "Le mot de passe est un champ requis."
     *                 },
     *                 "email": {
     *                     "L'email est un champ requis."
     *                 }     
     *             })
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error - Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object", example={
     *                 "username": {
     *                     "Le username est un champ requis."
     *                 },
     *                 "password": {
     *                     "Le mot de passe doit avoir au moins 6 caractères."
     *                 },
     *                 "email": {
     *                     "L'email doit être valide."
     *                 }
     *             })
     *         )
     *     ),
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6',
            'username' => 'required|string|unique:users',
            'name'     => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'name' => $request->name,
        ]);
        
        // Créer un utilisateur de base avec le rôle PLAYER
        $userRole = Role::where('name', 'PLAYER')->first();
        
        $user->roles()->attach($userRole);
        
        return response()->json([
            'content' => $user, 
            'message' => "User successfully created",
            'success' => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Sign in",
     *     description="Login by username and password",
     *     operationId="authLogin",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *        required=true,
     *        description="Pass user credentials",
     *        @OA\JsonContent(
     *           required={"password", "username"},
     *           @OA\Property(property="username", type="string", example="maestros21"),
     *           @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *        ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Error - Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logged in successfully"),
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJ...."),
     *             @OA\Property(property="token_type", type="number", example="3600"),
     *             @OA\Property(property="expires_in", type="string", example="eyJ0eXAiOiJKV1QiLCJ...."),
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {

        // validation
        $request->validate([
            "username" => "required",
            "password" => "required",
          
        ]);

        // verify user + token
        if (!$token = auth()->attempt(["username" => $request->username, "password" => $request->password])) {
            return response()->json([
                "success" => false,
                "message" => "Invalid credentials"
            ], 401);
        }

        // Get the authenticated user
        $user = auth()->user();

        // Load roles and permissions
        $user->load('roles', 'permissions');

        // Collect permissions from user's roles and user's direct permissions
        $userPermissions = $user->permissions->map(function ($permission) {
            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'description' => $permission->description,
            ];
        })->toArray();

        $rolePermissions = $user->roles->flatMap(function ($role) {
            return $role->permissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'description' => $permission->description,
                ];
            });
        })->unique('id')->values()->toArray();

        return response()->json([
            "success" => true,
            "message" => "Logged in successfully",
            "access_token" => $token,
            "token_type" => 'bearer',
            "expires_in" => auth()->factory()->getTTL() * 60,
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
                "username" => $user->username,
                "email" => $user->email,
                "roles" => $user->roles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                        'description' => $role->description,
                    ];
                }),
                "permissions" => array_merge($userPermissions, $rolePermissions),
            ]
        ]);
    }

    /**
     * @OA\POST(
     *     path="/api/auth/user",
     *     summary="Get user details",
     *     description="Retrieve details of the authenticated user",
     *     operationId="authUser",
     *     tags={"auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success - User details retrieved",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Error - Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\SecurityScheme(
     *         type="http",
     *         securityScheme="bearerAuth",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *         name="Authorization",
     *         description="JWT token required in the Authorization header."
     *     )
     * )
     */
    public function user()
    {
        $user = auth()->user();
        return response()->json(['data' => $user], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout",
     *     description="Invalidate the JWT token and log out the user",
     *     operationId="authLogout",
     *     tags={"auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Error - Invalid token",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid token")
     *         )
     *     ),
     *     @OA\SecurityScheme(
     *         type="http",
     *         securityScheme="bearerAuth",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *         name="Authorization",
     *         description="JWT token required in the Authorization header."
     *     )
     * )
     */
    public function logout()
    {
        try {
            JWTAuth::parseToken()->authenticate(); // Verify that the JWT token exists and is valid
            JWTAuth::invalidate(JWTAuth::getToken()); // Invalidate the JWT token
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }

}
