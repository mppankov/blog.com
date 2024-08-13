<?php

return [
    '~articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~(\d+)$~' => [\MyProject\Controllers\MainController::class, 'page'],
    '~before/(\d+)$~' => [\MyProject\Controllers\MainController::class, 'before'],
    '~after/(\d+)$~' => [\MyProject\Controllers\MainController::class, 'after'],
    '~^/$~' => [\MyProject\Controllers\MainController::class, 'main'],
];