<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Company\Employee\Presentation\Http\API\REST\Controllers\EmployeeController;

Route::group(
    ['prefix' => 'employees', 'controller' => EmployeeController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/{uuid}', 'show');
        $router->post('/', 'store');
        $router->post('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);

