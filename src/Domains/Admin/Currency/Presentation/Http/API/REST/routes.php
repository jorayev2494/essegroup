<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Currency\Presentation\Http\API\REST\Controllers\CurrencyController;

Route::group(
    ['prefix' => 'currencies', 'controller' => CurrencyController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
        $router->post('/', 'store');
    }
);
