<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Public\University\Presentation\Http\API\REST\Controllers\ApplicationController;
use Project\Domains\Public\University\Presentation\Http\API\REST\Controllers\UniversityController;

Route::group(
    ['prefix' => 'universities', 'controller' => UniversityController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/{uuid}', 'show');
    }
);

Route::group(
    ['prefix' => 'applications', 'controller' => ApplicationController::class],
    static function (Router $router): void {
        $router->post('/', 'store');
    }
);
