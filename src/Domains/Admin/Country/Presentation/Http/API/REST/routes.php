<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Country\Presentation\Http\API\REST\Controllers\CountryController;

Route::group(
    ['prefix' => 'countries', 'controller' => CountryController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->get('/{uuid}', 'show');
        $router->post('/', 'store');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);

