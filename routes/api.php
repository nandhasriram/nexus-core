<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\GameController;
use App\Models\User;
use App\Models\Character;

// 1. PUBLIC ROUTES (Anyone can read the lore)
Route::get('/games', [GameController::class, 'index']);

// 2. LOGIN ROUTE (Generates your secure API token)
Route::post('/login', function (Request $request) {
    $request->validate(['email' => 'required|email', 'password' => 'required']);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'ACCESS DENIED. Invalid credentials.'], 401);
    }

    // Issue the Master Token
    return response()->json([
        'token' => $user->createToken('nexus-core-key')->plainTextToken,
        'message' => 'ACCESS GRANTED.'
    ]);
});

// 3. SECURE VAULT (Only accessible with a valid token)
Route::middleware('auth:sanctum')->group(function () {

    // Game Controls
    Route::post('/games', [GameController::class, 'store']);
    Route::put('/games/{id}', [GameController::class, 'update']);
    Route::delete('/games/{id}', [GameController::class, 'destroy']);

    // Character Controls
    Route::post('/characters', function (Request $request) {
        $data = $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string',
            'class_type' => 'required|string',
        ]);
        return Character::create($data);
    });

});
