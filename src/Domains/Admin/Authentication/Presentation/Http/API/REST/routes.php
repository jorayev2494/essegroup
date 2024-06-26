<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Admin\Authentication\Presentation\Http\API\REST\Controllers\{
    LoginController,
    RefreshTokenController,
    Restore\RestorePasswordLinkController,
    Restore\RestorePasswordController,
};

Route::group(['prefix' => 'auth'], static function (Router $router): void {
    $router->post('/login', LoginController::class);
    $router->post('/refresh_token', RefreshTokenController::class);

    $router->group(['prefix' => 'restore-password', 'as' => 'restore_password.'], static function (Router $router): void {
        $router->post('/', RestorePasswordController::class);
        $router->post('/link', RestorePasswordLinkController::class);
    });
});

