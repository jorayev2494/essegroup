<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Public\Manager\Presentation\Http\API\REST\Controllers\ManagerController;

Route::group(
    ['prefix' => 'managers', 'controller' => ManagerController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
        $router->get('/{uuid}', 'show');
    }
);
