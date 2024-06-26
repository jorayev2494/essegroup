<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Student\Presentation\Http\API\REST\Controllers\StudentController;
use Project\Domains\Admin\Student\Presentation\Http\API\REST\Controllers\ActionController;

Route::group(
    ['prefix' => 'students', 'controller' => StudentController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->post('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');

        $router->get('/{uuid}/archive_documents', [ActionController::class, 'archiveDocuments']);
    }
);
