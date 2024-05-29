<?php

use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'templates'],
    static function (): void {
        Route::view('/admin/mails/layouts/index', 'mails.layouts.index', [
            'restoreLink' => getenv('APP_URL'),

            'firstName' => 'FIRST NAME',
            'lastName' => 'LAST NAME',
            'email' => 'EMAIL',
            'password' => 'PASSWORD',

            'dashboardLink' => getenv('APP_URL'),
        ]);

        Route::view('/admin/mails/auth/restore', 'mails.auth.restore.restorePasswordLink', [
            'firstName' => 'FIRST NAME',
            'lastName' => 'LAST NAME',
            'restoreLink' => getenv('APP_URL'),
        ]);

        Route::view('/admin/mails/employee/created', 'mails.company.employee.created', [
            'firstName' => 'FIRST NAME',
            'lastName' => 'LAST NAME',
            'email' => 'EMAIL',
            'password' => 'PASSWORD',
            'dashboardLink' => getenv('APP_URL'),
        ]);

        Route::view('/admin/mails/manager/created', 'mails.admin.manager.created', [
            'firstName' => 'FIRST NAME',
            'lastName' => 'LAST NAME',
            'email' => 'EMAIL',
            'password' => 'PASSWORD',
            'dashboardLink' => getenv('APP_URL'),
        ]);

        Route::view('/admin/mails/student/created', 'mails.admin.student.created', [
            'firstName' => 'FIRST NAME',
            'lastName' => 'LAST NAME',
            'email' => 'EMAIL',
            'password' => 'PASSWORD',
            'dashboardLink' => getenv('APP_URL'),
        ]);
    }
);
