<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Token\Presentation\Http\API\REST\Controllers\TokenController;

Route::group(
    ['prefix' => 'tokens', 'controller' => TokenController::class],
    static function (Router $router): void {
        $router->get('/centrifuge/generate_connection_token', 'centrifugeGenerateConnectionToken');
    }
);
