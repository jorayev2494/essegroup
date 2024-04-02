<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Language\Presentation\Http\API\REST\Controllers\LanguageController;

Route::group(
    ['prefix' => 'languages', 'controller' => LanguageController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);
