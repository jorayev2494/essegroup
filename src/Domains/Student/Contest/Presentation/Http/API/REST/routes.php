<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Student\Contest\Presentation\Http\API\REST\Controllers\ContestController;
use Project\Domains\Student\Contest\Presentation\Http\API\REST\Controllers\WonStudentController;

Route::group(
    ['prefix' => 'contests', 'controller' => ContestController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/{uuid}', 'show');

        $router->group(
            ['prefix' => '{uuid}/students', 'controller' => WonStudentController::class],
            static function (Router $router): void {
                $router->get('/', 'showContestStudent');
            }
        );
    }
);
