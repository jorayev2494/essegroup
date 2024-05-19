<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Public\StaticPage\Presentation\Http\API\REST\Controllers\StaticPageController;

Route::group(
    ['prefix' => 'static-pages', 'controller' => StaticPageController::class],
    static function (Router $router): void {
        $router->get('/{slug}', 'show');
    }
);
