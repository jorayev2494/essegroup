<?php

return [
    'url' => env('ADMIN_URL', 'http://127.0.0.1:8080'),
    'page_routers' => [
        'login' => '/en/auth/login',
        'reset_password' => '/en/auth/restore-password',
    ],
];
