<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Company\Presentation\Http\API\REST\Controllers\CompanyController;

Route::group(
    ['prefix' => 'companies', 'controller' => CompanyController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->post('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);
