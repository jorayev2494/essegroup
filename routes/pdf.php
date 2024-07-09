<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Preview\PDF\StudentController;

Route::group(
    ['prefix' => 'pdf', 'controller' => StudentController::class],
    static function (Router $router): void {
        $router->get('/preview/preview', 'preview');
    }
);
