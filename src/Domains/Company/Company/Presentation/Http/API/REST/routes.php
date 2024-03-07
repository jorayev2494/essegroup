<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Company\Company\Presentation\Http\API\REST\Controllers\CompanyController;

Route::group(
    ['prefix' => 'companies/companies', 'controller' => CompanyController::class],
    static function (Router $router): void {
        $router->get('/', 'show');
        $router->post('/{uuid}', 'update');
    }
);
