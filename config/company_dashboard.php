<?php

return [
    'url' => env('COMPANY_URL', 'http://127.0.0.1:8090'),
    'page_routers' => [
        'login' => '/en/company/auth/login',
        'reset_password' => '/en/company/auth/restore-password',
    ],
];
