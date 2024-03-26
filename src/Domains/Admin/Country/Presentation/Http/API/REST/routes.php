<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Country\Presentation\Http\API\REST\Controllers\CountryController;
use Project\Domains\Admin\Country\Presentation\Http\API\REST\Controllers\CityController;

Route::group(
    ['prefix' => 'countries'],
    static function (Router $router): void {
        $router->controller(CountryController::class)->group(
            static function (Router $router): void {
                $router->get('/', 'index');
                $router->get('/list', 'list');
                $router->get('/{uuid}', 'show');
                $router->post('/', 'store');
                $router->put('/{uuid}', 'update');
                $router->delete('/{uuid}', 'delete');
            }
        );
    }
);

Route::group(
    ['prefix' => 'countries/cities', 'controller' => CityController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);
