<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Public\Document\Presentation\Http\API\REST\Controllers\DocumentController;

Route::group(
    ['prefix' => 'documents', 'controller' => DocumentController::class],
    static function (Router $router): void {
        $router->get('/list', 'list');
        $router->get('/download/{uuid}', 'download');
    }
);
