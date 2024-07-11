<?php

use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/health', static fn () => ['status' => 'ok', 'message' => 'Working...']);

Route::any('*', static fn (): array => [
    'error' => true,
    'message' => 'Route not found',
]);
