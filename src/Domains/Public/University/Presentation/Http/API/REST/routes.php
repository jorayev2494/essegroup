<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Public\University\Presentation\Http\API\REST\Controllers\ApplicationController;
use Project\Domains\Public\University\Presentation\Http\API\REST\Controllers\UniversityController;
use Project\Domains\Public\University\Presentation\Http\API\REST\Controllers\FacultyController;
use Project\Domains\Public\University\Presentation\Http\API\REST\Controllers\DepartmentController;
use Project\Domains\Public\University\Presentation\Http\API\REST\Controllers\CountryController;

Route::group(
    ['prefix' => 'universities', 'controller' => UniversityController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
        $router->get('/{uuid}', 'show');
    }
);

Route::group(
    ['prefix' => 'departments', 'controller' => DepartmentController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
    }
);

Route::group(
    ['prefix' => 'applications', 'controller' => ApplicationController::class],
    static function (Router $router): void {
        $router->post('/', 'store');
    }
);

Route::group(
    ['prefix' => 'faculties', 'controller' => FacultyController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
    }
);

Route::group(
    ['prefix' => 'countries', 'controller' => CountryController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
    }
);
