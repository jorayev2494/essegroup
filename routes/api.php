<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/health', static fn () => ['status' => 'ok', 'message' => 'Working...']);

Route::group(
    ['prefix' => 'tests', 'controller' => \App\Http\Controllers\TestController::class],
    static function (Router $router): void {
        $router->get('/centrifuge', 'centrifuge');
        $router->get('/notification', 'notification')->middleware(['auth:admin']);
    }
);

Route::any('*', static fn (): array => [
    'error' => true,
    'message' => 'Route not found',
]);
