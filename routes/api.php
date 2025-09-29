<?php

use App\Http\Controllers\Api\OtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// OTP Authentication
Route::post('/otp/request', [OtpController::class, 'request']);
Route::post('/otp/verify', [OtpController::class, 'verify']);

// Property Click Tracking
Route::post('/clicks', function (Request $request) {
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'source' => 'nullable|string|max:32',
    ]);

    \App\Models\PropertyClick::create([
        'property_id' => $request->property_id,
        'source' => $request->source ?? 'unknown',
        'user_agent' => $request->userAgent(),
        'ip_hash' => hash('sha256', config('app.key') . $request->ip()),
        'created_at' => now(),
    ]);

    return response()->json(['success' => true]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
