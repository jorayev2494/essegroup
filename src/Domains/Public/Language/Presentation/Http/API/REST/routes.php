<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Public\Language\Presentation\Http\API\REST\Controllers\LanguageController;

Route::group(
    ['prefix' => 'languages', 'controller' => LanguageController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
    }
);
