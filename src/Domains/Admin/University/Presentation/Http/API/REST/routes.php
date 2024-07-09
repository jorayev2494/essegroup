<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\UniversityController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\FacultyController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\FacultyNameController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\DepartmentController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\DepartmentNameController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\ApplicationController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\DegreeController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\AliasController;
use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\ApplicationStatusValueController;

Route::group(
    ['prefix' => 'universities', 'controller' => UniversityController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
        $router->get('/search', 'search');
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

        $router->group(
            ['prefix' => 'names', 'controller' => FacultyNameController::class],
            static function (Router $router): void {
                $router->get('/', 'index');
                $router->get('/list', 'list');
                $router->post('/', 'store');
                $router->get('/{uuid}', 'show');
                $router->put('/{uuid}', 'update');
                $router->delete('/{uuid}', 'delete');
            }
        );
    }
);

Route::group(
    ['prefix' => 'departments', 'controller' => DepartmentController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');

        $router->group(
            ['prefix' => 'names', 'controller' => DepartmentNameController::class],
            static function (Router $router): void {
                $router->get('/', 'index');
                $router->get('/list', 'list');
                $router->post('/', 'store');
                $router->get('/{uuid}', 'show');
                $router->put('/{uuid}', 'update');
                $router->delete('/{uuid}', 'delete');
            }
        );
    }
);

Route::group(
    ['prefix' => 'applications', 'controller' => ApplicationController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/{student_uuid}/applications', 'studentApplications');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');

        $router->group(
            ['prefix' => 'statuses', 'controller' => ApplicationStatusValueController::class],
            static function (Router $router): void {
                $router->get('/', 'index');
                $router->get('/list', 'list');
                $router->get('/widget-list', 'widgetList');
                $router->post('/', 'store');
                $router->get('/{uuid}', 'show');
                $router->put('/{uuid}', 'update');
                $router->delete('/{uuid}', 'delete');
            }
        );
    }
);

Route::group(
    ['prefix' => 'degrees', 'controller' => DegreeController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);

Route::group(
    ['prefix' => 'aliases', 'controller' => AliasController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);
