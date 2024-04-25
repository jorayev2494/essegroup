<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Company\University\Presentation\Http\API\REST\Controllers\ApplicationController;
use Project\Domains\Company\University\Presentation\Http\API\REST\Controllers\ApplicationStatusValueController;
use Project\Domains\Company\University\Presentation\Http\API\REST\Controllers\DepartmentController;

Route::group(
    ['prefix' => 'applications', 'controller' => ApplicationController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/{student_uuid}/applications', 'studentApplications');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');

        $router->group(
            ['prefix' => 'statuses', 'controller' => ApplicationStatusValueController::class],
            static function (Router $router): void {
                $router->get('/list', 'list');
            }
        );
    }
);

Route::group(
    ['prefix' => 'departments', 'controller' => DepartmentController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
    }
);
