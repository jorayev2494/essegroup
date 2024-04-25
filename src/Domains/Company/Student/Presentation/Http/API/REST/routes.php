<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Company\Student\Presentation\Http\API\REST\Controllers\StudentController;

Route::group(
    ['prefix' => 'students', 'controller' => StudentController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->post('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);

