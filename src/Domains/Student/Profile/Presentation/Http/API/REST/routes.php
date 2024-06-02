<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Student\Profile\Presentation\Http\API\REST\Controllers\ProfileController;

Route::group(
    ['prefix' => 'profile', 'controller' => ProfileController::class],
    static function (Router $router): void {
        $router->get('/', 'show');
        $router->post('/', 'update');
        $router->post('/change-password', 'changePassword');
    }
);
