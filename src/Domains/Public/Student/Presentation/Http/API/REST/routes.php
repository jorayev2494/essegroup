<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Public\Student\Presentation\Http\API\REST\Controllers\StudentController;

Route::group(
    ['prefix' => 'students', 'controller' => StudentController::class],
    static function (Router $router): void {
        $router->post('/', 'store');
    }
);

use Project\Domains\Admin\University\Presentation\Http\API\REST\Controllers\EmailApplicationController;

Route::group(
    ['prefix' => 'email-application', 'controller' => EmailApplicationController::class],
    static function (Router $router): void {
        $router->post('/', 'store');
    }
);
