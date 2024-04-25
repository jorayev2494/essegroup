<?php

use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::any('*', static fn (): array => [
    'error' => true,
    'message' => 'Route not found',
]);
