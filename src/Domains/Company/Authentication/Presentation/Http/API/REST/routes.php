<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Project\Domains\Company\Authentication\Presentation\Http\API\REST\Controllers\{
    LoginController,
    LogoutController,
    RefreshTokenController,
    Restore\RestorePasswordLinkController,
    Restore\RestorePasswordController,
};

Route::group(['prefix' => 'auth'], static function (Router $router): void {
    $router->post('/login', LoginController::class);
    $router->post('/refresh-token', RefreshTokenController::class);
    $router->post('/logout', LogoutController::class);

    $router->group(['prefix' => 'restore-password', 'as' => 'restore_password.'], static function (Router $router): void {
        $router->put('/restore', RestorePasswordController::class);
        $router->post('/link', RestorePasswordLinkController::class);
    });
});
