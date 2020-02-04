<?php

return [
    'app' => [
        'name' => 'Bookshelf'
    ],
    'auth' => [
        'defaultRedirectPath' => '/'
    ],
    'database' => [
        'name' => env('db_name', 'bookshelf'),
        'username' => env('db_username', 'root'),
        'password' => env('db_password', 'root'),
        'connection' => env('db_connection', 'mysql:host=127.0.0.1'),
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
