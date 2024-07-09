<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Contest\Presentation\Http\API\REST\Controllers\ContestController;
use Project\Domains\Admin\Contest\Presentation\Http\API\REST\Controllers\WonStudentController;

Route::group(
    ['prefix' => 'contests', 'controller' => ContestController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/participants', 'participants');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');

        $router->group(
            ['prefix' => '{uuid}/students', 'controller' => WonStudentController::class],
            static function (Router $router): void {
                $router->get('/', 'index');
                $router->get('/{studentUuid}', 'showContestStudent');
                $router->get('/{code}/code', 'show');
                $router->post('/', 'store');
                $router->put('/{code}', 'update');
            }
        );
    }
);
