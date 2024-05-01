<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Profile\Presentation\Http\API\REST\Controllers\ProfileController;

Route::group(
    ['prefix' => 'profiles', 'controller' => ProfileController::class],
    static function (Router $router): void {
        $router->get('/', 'show');
        $router->post('/', 'update');
    }
);
