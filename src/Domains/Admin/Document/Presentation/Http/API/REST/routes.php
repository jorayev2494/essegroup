<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Document\Presentation\Http\API\REST\Controllers\DocumentController;

Route::group(
    ['prefix' => 'documents', 'controller' => DocumentController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->get('/download/{uuid}', 'download');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->post('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');

        $router->get('/types/list', 'types');
    }
);
