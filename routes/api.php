<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\JournalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API Journal Core is online and ready.',
        'timestamp' => now()->toIso8601String()
    ], 200);
});

// Endpoint khusus untuk jurnal
Route::post('/journals', [JournalController::class, 'store']);