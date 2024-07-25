<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers\ManagerController;
use Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers\RoleController;
use Project\Domains\Admin\Manager\Presentation\Http\API\REST\Controllers\PermissionController;

Route::group(
    ['prefix' => 'managers', 'controller' => ManagerController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->post('/{uuid}', 'update');
        $router->delete('/{uuid}', 'delete');
    }
);

Route::group(
    ['prefix' => 'roles', 'controller' => RoleController::class],
    static function (Router $router): void {
        $router->get('/', 'index');
        $router->get('/list', 'list');
        $router->post('/', 'store');
        $router->get('/{uuid}', 'show');
        $router->put('/{uuid}', 'update');
        $router->put('/{uuid}/permissions', 'updatePermissions');
        $router->delete('/{uuid}', 'delete');

        $router->get('/{uuid}/permissions', [PermissionController::class, 'getPermissionsByRoleUuid']);

        $router->group(
            ['prefix' => 'permissions', 'controller' => PermissionController::class],
            static function (Router $router): void {
                $router->get('/', 'index');
                $router->get('/list', 'list');
                $router->get('/{id}', 'show');
                $router->put('/{id}', 'update');
            }
        );
    }
);
