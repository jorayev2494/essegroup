<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Student\Presentation\Http\Web\REST\Controllers\PDFController;

Route::group(
    ['prefix' => 'pdf', 'controller' => PDFController::class],
    static function (Router $router): void {
        $router->get('/preview/{uuid}', 'preview');
    }
);
