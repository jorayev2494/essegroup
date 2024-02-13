<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\UniversityController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\FacultyController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\DepartmentController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\ApplicationController;

Route::group(
    ['prefix' => 'universities', 'controller' => UniversityController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->post('/{uuid}', 'update');
            $router->delete('/{uuid}', 'delete');
    }
);

Route::group(
    ['prefix' => 'faculties', 'controller' => FacultyController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->post('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);

Route::group(
    ['prefix' => 'departments', 'controller' => DepartmentController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);

Route::group(
    ['prefix' => 'applications', 'controller' => ApplicationController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);
