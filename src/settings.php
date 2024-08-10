<?php

use MyProject\Services\Config;

$file = __DIR__ . '/../.env';
$localFile = __DIR__ . '/../.env.local';

$env = array_merge(Config::load($file), Config::load($localFile));

return [
    'db' => [
        'host' => $env['DB_HOST'],
        "dbname" => $env['DB_NAME'],
        'user' => $env['DB_USER'],
        'password' => $env['DB_PASSWORD'],
    ]
];
