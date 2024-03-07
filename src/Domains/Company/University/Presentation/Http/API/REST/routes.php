<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Company\University\Presentation\Http\API\REST\Controllers\UniversityController;

Route::group([
        'prefix' => 'universities/universities',
        'controller' => UniversityController::class,
    ], static function (Router $router): void {
        $router->get('/', 'index');
    }
);
