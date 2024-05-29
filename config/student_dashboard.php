<?php

return [
    'url' => env('STUDENT_URL', 'http://127.0.0.1:8090'),
    'page_routers' => [
        'login' => '/en/student/auth/login',
        'reset_password' => '/en/student/auth/restore-password',
    ],
];
