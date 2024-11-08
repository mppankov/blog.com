<?php

return [
    '~^/$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^(\d+)$~' => [\MyProject\Controllers\MainController::class, 'page'],
    '~before/(\d+)$~' => [\MyProject\Controllers\MainController::class, 'before'],
    '~after/(\d+)$~' => [\MyProject\Controllers\MainController::class, 'after'],
    '~articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'view'],
    '~articles/(\d+)/comments/add$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~comments/(\d+)/delete$~' => [\MyProject\Controllers\CommentsController::class, 'delete'],
    '~users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'], 
];