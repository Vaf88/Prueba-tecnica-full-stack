<?php

use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt($request->only('email', 'password'))) {
        $user = auth()->user();
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
});

Route::get('/users', [UserController::class, 'index']);
Route::apiResource('tickets', TicketController::class)->only(['index', 'store']);