<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Public\Company\Presentation\Http\API\REST\Controllers\CompanyController;

Route::group(
    ['prefix' => 'companies', 'controller' => CompanyController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
    }
);
