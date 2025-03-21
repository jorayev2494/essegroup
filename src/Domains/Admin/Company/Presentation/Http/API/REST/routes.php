<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Company\Presentation\Http\API\REST\Controllers\CompanyController;
use Project\Domains\Admin\Company\Presentation\Http\API\REST\Controllers\EmployeeController;

Route::group(
    ['prefix' => 'companies', 'controller' => CompanyController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->post('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');

        Route::group(
            ['prefix' => 'employees', 'controller' => EmployeeController::class],
            static function (Router $router): void {
                $router->get('/', 'index');
                $router->post('/', 'store');
                $router->get('/{uuid}', 'show');
                $router->post('/{uuid}', 'update');
                $router->delete('/{uuid}', 'delete');
            }
        );
    }
);
